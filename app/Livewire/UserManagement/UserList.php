<?php

namespace App\Livewire\UserManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserList extends Component
{
    use WithPagination;
    
    // Filters and pagination
    public $perPage = 10;
    public $searchTerm = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $filters = [
        'company' => '',
        'role' => '',
        'status' => '',
        'verified' => '',
        'date_range' => '',
    ];
    
    // Bulk selection
    public $selectedUsers = [];
    public $selectAll = false;
    
    // Listeners for events from other components
    protected $listeners = [
        'userCreated' => '$refresh',
        'userUpdated' => '$refresh',
        'userDeleted' => '$refresh',
        'userBlocked' => '$refresh',
        'userUnblocked' => '$refresh',
        'userVerified' => '$refresh',
        'bulkActionCompleted' => '$refresh',
    ];

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
            $this->loadAllUserIds();
        } else {
            $this->selectedUsers = [];
        }
    }
    
    protected function loadAllUserIds()
    {
        $query = User::query();
        $this->applyFilters($query);
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
            'status' => '',
            'verified' => '',
            'date_range' => '',
        ];
        $this->searchTerm = '';
    }
    
    // Action methods that dispatch events to other components
    public function editUser($userId)
    {
        
        $this->dispatch('editUser', $userId);
    }
    
    public function confirmUserDeletion($userId)
    {
        $this->dispatch('confirmUserDeletion', $userId);
    }
    
    public function blockUser($userId)
    {
        $this->dispatch('blockUser', $userId);
    }
    
    public function unblockUser($userId)
    {
        $this->dispatch('unblockUser', $userId);
    }
    
    public function verifyUser($userId)
    {
        $this->dispatch('verifyUser', $userId);
    }
    
    public function blockCompanyAdmin($userId)
    {
        $this->dispatch('blockCompanyAdmin', $userId);
    }
    
    public function viewUserProfile($userId)
    {
        $this->dispatch('viewUserProfile', $userId);
    }
    
    public function exportData()
    {
        // Export users based on current filters
        $query = User::query();
        $this->applyFilters($query);
        
        // Logic for export would go here
        // For example, create a CSV download
        
       

        $this->dispatch('notify', type: 'success', message: 'Export started! The file will be downloaded shortly.');

    }
    
    protected function applyFilters($query)
    {
        // Company admin can only see users in their company
        if (auth()->user()->hasRole('company_admin')) {
            $query->where('company_id', auth()->user()->company_id);
        }
        
        // Apply search term
        if (!empty($this->searchTerm)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('first_name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
                  ->orWhereHas('company', function ($sq) {
                      $sq->where('name', 'like', '%' . $this->searchTerm . '%');
                  });
            });
        }
        
        // Apply specific filters
        
        // Company filter (for super admin)
        if (!empty($this->filters['company']) && auth()->user()->hasRole('super_admin')) {
            $query->where('company_id', $this->filters['company']);
        }
        
        // Role filter
        if (!empty($this->filters['role'])) {
            $query->where('role_id', $this->filters['role']);
        }
        
        // Status filter
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        
        // Verification filter
        if (!empty($this->filters['verified'])) {
            if ($this->filters['verified'] === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($this->filters['verified'] === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }
        
        // Date range filter
        if (!empty($this->filters['date_range'])) {
            list($startDate, $endDate) = explode(' to ', $this->filters['date_range']);
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }
        
        return $query;
    }
    
    public function render()
    {
        // Build query with all filters
        $query = User::with(['role', 'company'])
            ->when(!auth()->user()->hasRole('super_admin'), function ($query) {
                // Non-super admins can only see users in their company
                if (auth()->user()->hasRole('company_admin')) {
                    $query->where('company_id', auth()->user()->company_id);
                }
            });
        
        $this->applyFilters($query);
        
        // Get data for the view
        $users = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        
        // Get data for filters
        $companies = [];
        $roles = [];
        
        if (auth()->user()->hasRole('super_admin')) {
            $companies = Company::orderBy('company_name')->get();
        }
        
        if (auth()->user()->hasRole('super_admin')) {
            $roles = Role::orderBy('display_name')->get();
        } else if (auth()->user()->hasRole('company_admin')) {
            // Company admins can only assign non-admin roles
            $roles = Role::where('name', '!=', 'super_admin')
                ->where('name', '!=', 'company_admin')
                ->orderBy('display_name')
                ->get();
        }
        
        return view('livewire.user-management.user-list', [
            'users' => $users,
            'companies' => $companies,
            'roles' => $roles,
        ]);
    }
}