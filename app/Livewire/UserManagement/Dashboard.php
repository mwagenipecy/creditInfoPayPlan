<?php

namespace App\Livewire\UserManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\AccessRequest;
use App\Models\ExternalUser;
use App\Models\UserGroup;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
class Dashboard extends Component
{
    use WithPagination;

    public $activeTab = 'internal';
    public $searchTerm = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $showCreateModal = false;
    public $showRequestModal = false;
    public $requestType = 'individual';

    public $internalUsers=[];

    public $showDeleteModal=false;
    public $availableUsers;
    
    // User form properties
    public $userId;
    public $name;
    public $email;
    public $role = 'user';
    public $password;
    public $selectedUsers = [];
    public $selectedGroups = [];
    public $userGroups = [];
    public $requestReason = '';
    public $accessLevel = 'read';
    public $expiryDate = null;

public $targetUserId;
public $groupName;
public $userCount;
public $justification;

    
    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users',
        'role' => 'required',
        'password' => 'required|min:8',
    ];



    /**
 * Request access for a specific external user
 *
 * @param int $userId The ID of the external user
 * @return void
 */
public function requestAccessForUser($userId)
{
    // Find the external user by ID
    $externalUser = ExternalUser::findOrFail($userId);
    
    // Initialize variables for the modal
    $this->targetUserId = $userId;
    $this->requestType = 'individual';
    $this->accessLevel = 'read'; // Default to read access
    $this->justification = '';
    $this->expiryDate = now()->addMonths(3)->format('Y-m-d'); // Default expiry of 3 months
    
    // Reset any validation errors
    $this->resetErrorBag();
    
    // Open the request modal
    $this->showRequestModal = true;
}

/**
 * Create an access request based on form data
 *
 * @return void
 */
public function createAccessRequest()
{
    // Validate the request data
    $this->validate([
        'requestType' => 'required|in:individual,group',
        'accessLevel' => 'required|in:read,write,admin',
        'justification' => 'required|string|min:10',
        'expiryDate' => 'required|date|after:today',
    ]);
    
    // Additional validation based on request type
    if ($this->requestType === 'individual') {
        $this->validate([
            'targetUserId' => 'required|exists:external_users,id',
        ]);
    } else {
        $this->validate([
            'groupName' => 'required|string|min:3',
            'userCount' => 'required|integer|min:2|max:50',
        ]);
    }
    
    try {
        // Start a database transaction
        DB::beginTransaction();
        
        if ($this->requestType === 'individual') {
            // Create an access request for an individual user
            AccessRequest::create([
                'requester_id' => auth()->id(),
                'external_user_id' => $this->targetUserId,
                'user_group_id' => null,
                'reason' => $this->justification,
                'access_level' => $this->accessLevel,
                'expiry_date' => $this->expiryDate,
                'status' => 'pending',
            ]);
        } else {
            // Create a new user group
            $userGroup = UserGroup::create([
                'name' => $this->groupName,
                'description' => "Group created by " . auth()->user()->name . " on " . now()->format('Y-m-d'),
            ]);
            
            // Create an access request for the group
            AccessRequest::create([
                'requester_id' => auth()->id(),
                'external_user_id' => null, 
                'user_group_id' => $userGroup->id,
                'reason' => $this->justification,
                'access_level' => $this->accessLevel,
                'expiry_date' => $this->expiryDate,
                'status' => 'pending',
            ]);
        }
        
        // Commit the transaction
        DB::commit();
        
        // Close the modal and show a success message
        $this->showRequestModal = false;
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Access request submitted successfully!'
        ]);
        
    } catch (\Exception $e) {
        // Rollback the transaction if something went wrong
        DB::rollBack();
        
        // Show an error message
        $this->dispatchBrowserEvent('notify', [
            'type' => 'error',
            'message' => 'Failed to submit access request: ' . $e->getMessage()
        ]);
    }
    
    // Reset form fields
    $this->resetExcept(['activeTab', 'searchTerm', 'pendingRequests']);
}



    public function mount()
    {
        $this->userGroups = UserGroup::all();
        $this->internalUsers=User::get();
    }

    public function updatedActiveTab()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function createUser()
    {
        $this->validate();
        
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'password' => Hash::make($this->password),
        ]);
        
        $this->reset(['name', 'email', 'role', 'password', 'showCreateModal']);
      //  $this->dispatchBrowserEvent('user-created', ['message' => 'User created successfully!']);
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = '';
        
        $this->showCreateModal = true;
    }

    public function updateUser()
    {
        $user = User::findOrFail($this->userId);
        
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.$this->userId,
            'role' => 'required',
            'password' => 'nullable|min:8',
        ]);
        
        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];
        
        if (!empty($this->password)) {
            $userData['password'] = Hash::make($this->password);
        }
        
        $user->update($userData);
        
        $this->reset(['userId', 'name', 'email', 'role', 'password', 'showCreateModal']);
        $this->dispatchBrowserEvent('user-updated', ['message' => 'User updated successfully!']);
    }

    public function confirmUserDeletion($id)
    {
        $this->userId = $id;
       // $this->dispatchBrowserEvent('confirm-user-deletion');
    }

    public function deleteUser()
    {
        $user = User::findOrFail($this->userId);
        $user->delete();
        
        $this->reset('userId');
        $this->dispatchBrowserEvent('user-deleted', ['message' => 'User deleted successfully!']);
    }

    // public function createAccessRequest()
    // {
    //     if ($this->requestType === 'individual') {
    //         $this->validate([
    //             'selectedUsers' => 'required|array|min:1',
    //             'requestReason' => 'required|min:10',
    //             'accessLevel' => 'required',
    //             'expiryDate' => 'nullable|date|after:today',
    //         ]);
            
    //         foreach ($this->selectedUsers as $userId) {
    //             AccessRequest::create([
    //                 'requester_id' => Auth::id(),
    //                 'external_user_id' => $userId,
    //                 'reason' => $this->requestReason,
    //                 'access_level' => $this->accessLevel,
    //                 'expiry_date' => $this->expiryDate,
    //                 'status' => 'pending',
    //             ]);
    //         }
    //     } else {
    //         $this->validate([
    //             'selectedGroups' => 'required|array|min:1',
    //             'requestReason' => 'required|min:10',
    //             'accessLevel' => 'required',
    //             'expiryDate' => 'nullable|date|after:today',
    //         ]);
            
    //         foreach ($this->selectedGroups as $groupId) {
    //             $group = UserGroup::findOrFail($groupId);
    //             foreach ($group->externalUsers as $user) {
    //                 AccessRequest::create([
    //                     'requester_id' => Auth::id(),
    //                     'external_user_id' => $user->id,
    //                     'user_group_id' => $groupId,
    //                     'reason' => $this->requestReason,
    //                     'access_level' => $this->accessLevel,
    //                     'expiry_date' => $this->expiryDate,
    //                     'status' => 'pending',
    //                 ]);
    //             }
    //         }
    //     }
        
    //     $this->reset(['selectedUsers', 'selectedGroups', 'requestReason', 'accessLevel', 'expiryDate', 'showRequestModal']);
    //     $this->dispatchBrowserEvent('request-created', ['message' => 'Access request submitted successfully!']);
    // }

    public function approveRequest($id)
    {
        $request = AccessRequest::findOrFail($id);
        $request->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        
        // Update external user's access
        $externalUser = ExternalUser::findOrFail($request->external_user_id);
        $externalUser->update([
            'has_access' => true,
            'access_level' => $request->access_level,
            'access_expires_at' => $request->expiry_date,
        ]);
        
        $this->dispatchBrowserEvent('request-approved', ['message' => 'Request approved successfully!']);
    }

    public function rejectRequest($id)
    {
        $request = AccessRequest::findOrFail($id);
        $request->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        
        $this->dispatchBrowserEvent('request-rejected', ['message' => 'Request rejected!']);
    }

    public function revokeAccess($id)
    {
        $externalUser = ExternalUser::findOrFail($id);
        $externalUser->update([
            'has_access' => false,
            'access_revoked_at' => now(),
            'access_revoked_by' => Auth::id(),
        ]);
        
        $this->dispatchBrowserEvent('access-revoked', ['message' => 'User access revoked successfully!']);
    }

    public function render()
    {
        $query = $this->activeTab === 'internal' 
            ? User::query() 
            : ExternalUser::query();
            
        if (!empty($this->searchTerm)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            });
        }
        
        $users = $query->orderBy($this->sortField, $this->sortDirection)
                       ->paginate(10);
                       
        $pendingRequests = AccessRequest::where('status', 'pending')->count();
        
        return view('livewire.user-management.dashboard', [
            'users' => $users,
            'pendingRequests' => $pendingRequests,
            'externalUsers' => ExternalUser::whereNotIn('id', $this->selectedUsers)->get(),
            'accessRequests' => AccessRequest::with(['requester', 'externalUser'])
                ->orderBy('created_at', 'desc')
                ->paginate(10),
        ]);
    }
}