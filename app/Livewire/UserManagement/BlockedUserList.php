<?php

namespace App\Livewire\UserManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class BlockedUserList extends Component
{
    use WithPagination;
    
    public $perPage = 10;
    public $searchTerm = '';
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';
    public $filters = [
        'company' => '',
        'role' => '',
        'block_type' => '', // 'user' or 'company'
    ];
    
    // Bulk selection
    public $selectedUsers = [];
    public $selectAll = false;
    
    // Listen for events from other components
    protected function getListeners()
    {
        return [
            'userBlocked' => '$refresh',
            'userUnblocked' => '$refresh',
            'filtersReset' => 'resetFilters',
        ];
    }



    public function unblockUser($userId)
    {
        $this->dispatch('unblockUser', $userId);
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
            $this->loadAllBlockedUserIds();
        } else {
            $this->selectedUsers = [];
        }
    }
    
    protected function loadAllBlockedUserIds()
    {
        $query = $this->buildBlockedQuery();
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
            'block_type' => '',
        ];
        $this->searchTerm = '';
        $this->resetPage();
    }
    
    protected function buildBlockedQuery()
    {
        // Base query - only blocked users
        $query = User::with(['role', 'company'])
            ->where(function ($q) {
                $q->where('status', 'inactive')
                  ->orWhereHas('company', function ($sq) {
                      $sq->where('is_blocked', true);
                  });
            });
            
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
        
        // Filter by block type
        if (!empty($this->filters['block_type'])) {
            if ($this->filters['block_type'] === 'user') {
                $query->where('status', 'inactive')
                      ->whereDoesntHave('company', function ($q) {
                          $q->where('is_blocked', true);
                      });
            } elseif ($this->filters['block_type'] === 'company') {
                $query->whereHas('company', function ($q) {
                    $q->where('is_blocked', true);
                });
            }
        }
        
        return $query;
    }
    
    // Unblock user
   
    
    // Unblock selected users
    public function unblockSelected()
    {
        if (empty($this->selectedUsers)) {
            $this->dispatch('notify', type: 'error', message: 'No users selected.');
            return;
        }
        
        try {
            DB::beginTransaction();
            
            foreach ($this->selectedUsers as $userId) {
                $user = User::find($userId);
                
                // Skip users from blocked companies - they need company unblocking first
                if ($user->company && $user->company->is_blocked) {
                    continue;
                }
                
                // Unblock the user
                $user->update([
                    'status' => 'active'
                ]);
                
                // Log activity would go here...
            }
            
            DB::commit();
            
            // Reset selection
            $this->selectedUsers = [];
            $this->selectAll = false;
            
            $this->dispatch('notify', type: 'success', message: 'Selected users unblocked successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->dispatch('notify', type: 'error', message: 'Error: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        $query = $this->buildBlockedQuery();
        
        $blockedUsers = $query->orderBy($this->sortField, $this->sortDirection)
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
        
        return view('livewire.user-management.blocked-user-list', [
            'blockedUsers' => $blockedUsers,
            'companies' => $companies,
            'roles' => $roles,
        ]);
    }
}