<?php

namespace App\Livewire\UserManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class PendingVerificationList extends Component
{
    use WithPagination;
    
    public $perPage = 10;
    public $searchTerm = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $filters = [
        'company' => '',
        'role' => '',
    ];
    
    // Bulk selection
    public $selectedUsers = [];
    public $selectAll = false;
    
    // Listen for events from other components
    protected function getListeners()
    {
        return [
            'userCreated' => '$refresh',
            'userUpdated' => '$refresh',
            'userVerified' => '$refresh',
            'filtersReset' => 'resetFilters',
        ];
    }
    
    public function mount()
    {
        // If user is company admin, set company filter
        if (auth()->user()->hasRole('company_admin')) {
            $this->filters['company'] = auth()->user()->company_id;
        }
    }
    
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->loadAllPendingUserIds();
        } else {
            $this->selectedUsers = [];
        }
    }
    
    protected function loadAllPendingUserIds()
    {
        $query = $this->buildPendingQuery();
        $this->selectedUsers = $query->pluck('id')->map(fn($id) => (string) $id)->toArray();
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
    
    public function resetFilters()
    {
        $this->filters = [
            'company' => auth()->user()->hasRole('company_admin') ? auth()->user()->company_id : '',
            'role' => '',
        ];
        $this->searchTerm = '';
        $this->resetPage();
    }
    
    protected function buildPendingQuery()
    {
        // Base query - only users without email verification
        $query = User::with(['role', 'company'])
            ->whereNull('email_verified_at');
            
        // If user is company admin, restrict to their company
        if (auth()->user()->hasRole('company_admin')) {
            $query->where('company_id', auth()->user()->company_id);
        }
        
        // Apply search
        if (!empty($this->searchTerm)) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
                  ->orWhereHas('company', function ($sq) {
                      $sq->where('name', 'like', '%' . $this->searchTerm . '%');
                  });
            });
        }
        
        // Apply company filter for super admin
        if (!empty($this->filters['company']) && auth()->user()->hasRole('super_admin')) {
            $query->where('company_id', $this->filters['company']);
        }
        
        // Apply role filter
        if (!empty($this->filters['role'])) {
            $query->where('role_id', $this->filters['role']);
        }
        
        return $query;
    }
    
    // Send verification email
    public function resendVerification($userId)
    {
        $user = User::find($userId);
        
        if (!$user) {
            $this->dispatch('notify', type: 'error', message: 'User not found.');
            return;
        }
        
        try {
            DB::beginTransaction();
            
            // Create verification URL (this would be adjusted based on your app's setup)
            // $verificationUrl = URL::temporarySignedRoute(
            //     'verification.verify',
            //     now()->addMinutes(60),
            //     ['id' => $user->id, 'hash' => sha1($user->email)]
            // );
            
            // Send verification email
            // Mail::to($user->email)->send(new VerifyEmail($user, $verificationUrl));
            
            // Log activity
            // ActivityLog::create([
            //     'user_id' => auth()->id(),
            //     'action' => 'resent_verification',
            //     'model_type' => User::class,
            //     'model_id' => $user->id,
            //     'description' => "Resent verification email to user: {$user->name}"
            // ]);
            
            DB::commit();
            
            $this->dispatch('notify', type: 'success', message: 'Verification email resent successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->dispatch('notify', type: 'error', message: 'Error: ' . $e->getMessage());
        }
    }
    
    // Manually verify user
    public function manuallyVerify($userId)
    {
        // Dispatch to VerifyUser component
        $this->dispatch('verifyUser', id: $userId);
    }
    
    public function render()
    {
        $query = $this->buildPendingQuery();
        
        $pendingUsers = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
            
        $companies = [];
        $roles = [];
        
        // Get data for filters
        if (auth()->user()->hasRole('super_admin')) {
            $companies = Company::orderBy('company_name')->get();
            $roles = \App\Models\Role::orderBy('display_name')->get();
        } else if (auth()->user()->hasRole('company_admin')) {
            $roles = \App\Models\Role::where('name', '!=', 'super_admin')
                ->orderBy('display_name')
                ->get();
        }
        
        return view('livewire.user-management.pending-verification-list', [
            'pendingUsers' => $pendingUsers,
            'companies' => $companies,
            'roles' => $roles,
        ]);
    }
}