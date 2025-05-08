<?php

namespace App\Livewire\UserManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class AdminList extends Component
{
    use WithPagination;
    
    public $perPage = 10;
    public $searchTerm = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $filters = [
        'company' => '',
        'status' => '',
    ];
    
    // Bulk selection
    public $selectedAdmins = [];
    public $selectAll = false;
    
    // Listen for events from other components
    protected function getListeners()
    {
        return [
            'userCreated' => '$refresh',
            'userUpdated' => '$refresh',
            'userBlocked' => '$refresh',
            'userUnblocked' => '$refresh',
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
            $this->loadAllAdminIds();
        } else {
            $this->selectedAdmins = [];
        }
    }
    
    protected function loadAllAdminIds()
    {
        $query = $this->buildAdminQuery();
        $this->selectedAdmins = $query->pluck('id')->map(fn($id) => (string) $id)->toArray();
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
            'status' => '',
        ];
        $this->searchTerm = '';
        $this->resetPage();
    }
    
    protected function buildAdminQuery()
    {
        // Get the admin role IDs
        $adminRoleIds = Role::whereIn('name', ['super_admin', 'company_admin'])->pluck('id');
        
        // Base query - only admin users
        $query = User::with(['role', 'company'])
            ->whereIn('role_id', $adminRoleIds);
            
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
        
        // Apply status filter
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        
        return $query;
    }
    
    public function render()
    {
        $query = $this->buildAdminQuery();
        
        $admins = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
            
        $companies = [];
        
        // Get companies for filter (only for super admin)
        if (auth()->user()->hasRole('super_admin')) {
            $companies = Company::orderBy('company_name')->get();
        }
        
        return view('livewire.user-management.admin-list', [
            'admins' => $admins,
            'companies' => $companies,
        ]);
    }
}