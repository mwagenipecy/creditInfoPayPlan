<?php

namespace App\Livewire\UserManagement;

use Livewire\Component;
use App\Models\User;
use App\Models\Company;
use App\Models\Role;
use App\Models\ActivityLog;

class Dashboard extends Component
{
    // Tab and state management
    public $activeTab = 'all_users';
    public $perPage = 10;

    public $showDeleteModal=false;
    public $searchTerm = '';
    public $filters = [
        'company' => '',
        'role' => '',
        'status' => '',
        'verified' => '',
        'date_range' => '',
    ];
    
    // Selection for bulk actions
    public $selectedUsers = [];
    
    // Stats
    public $totalUsers = 0;
    public $activeUsers = 0;
    public $activeAdmins = 0;
    public $companyAdmins = 0;
    public $pendingVerifications = 0;
    public $recentVerifications = 0;
    public $blockedUsers = 0;
    public $blockedCompanies = 0;
    
    // Listen for events from child components
    protected $listeners = [
        'userCreated' => 'refreshData',
        'userUpdated' => 'refreshData',
        'userDeleted' => 'refreshData',
        'userBlocked' => 'refreshData',
        'userUnblocked' => 'refreshData',
        'userVerified' => 'refreshData',
        'bulkActionCompleted' => 'refreshData',
    ];
    
    public function mount()
    {
        // Initialize with default tab
        $this->activeTab = 'all_users';
        
        // If user is company admin, set company filter
        if (auth()->user()->hasRole('company_admin')) {
            $this->filters['company'] = auth()->user()->company_id;
        }
        
        // Load initial data
        $this->refreshData();
    }
    
    public function refreshData()
    {
        // Calculate dashboard stats
        $this->calculateStats();
    }
    
    public function updatedActiveTab()
    {
        // Reset selection when changing tabs
        $this->selectedUsers = [];
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
        
        // Emit event to child components
        $this->dispatch('filtersReset');
    }
    


    public function setTab($activeTab, $tabName){

        $this->activeTab=$tabName;
    }
    public function exportData()
    {
        // This method would be implemented for full export functionality
        // Could use Laravel Excel or other export library
        
        // $this->dispatchBrowserEvent('notify', [
        //     'type' => 'success',
        //     'message' => 'Export started! The file will be downloaded shortly.'
        // ]);

        $this->dispatch('notify', type: 'success', message: 'Export started! The file will be downloaded shortly.');

    }
    
    protected function calculateStats()
    {
        // Query builder for user stats - respect company admin restrictions
        $userQuery = User::query();
        
        if (auth()->user()->hasRole('company_admin')) {
            $userQuery->where('company_id', auth()->user()->company_id);
        }
        
        // Total users
        $this->totalUsers = $userQuery->count();
        
        // Active users
        $this->activeUsers = (clone $userQuery)->where('status', 'active')->count();
        
        // Active admins
        $this->activeAdmins = (clone $userQuery)
            ->where('status', 'active')
            ->whereHas('role', function($query) {
                $query->whereIn('name', ['super_admin', 'company_admin']);
            })
            ->count();
        
        // Company admins
        $this->companyAdmins = (clone $userQuery)
            ->whereHas('role', function($query) {
                $query->where('name', 'company_admin');
            })
            ->count();
        
        // Pending verifications
        $this->pendingVerifications = (clone $userQuery)
            ->whereNull('email_verified_at')
            ->count();
        
        // Recent verifications (last 7 days)
        $this->recentVerifications = (clone $userQuery)
            ->whereNotNull('email_verified_at')
            ->where('email_verified_at', '>=', now()->subDays(7))
            ->count();
        
        // Blocked users
        $this->blockedUsers = (clone $userQuery)
            ->where('status', 'inactive')
            ->count();
        
        // Blocked companies - only for super admin
        if (auth()->user()->hasRole('super_admin')) {
            $this->blockedCompanies = Company::where('is_blocked', true)->count();
        } else {
            $this->blockedCompanies = 0;
        }
    }
    
    public function render()
    {
        // Get data for filters
        $companies = [];
        $roles = [];
        
        if (auth()->user()->hasRole('super_admin')) {
            $companies = Company::orderBy('company_name')->get();
            $roles = Role::orderBy('display_name')->get();
        } else if (auth()->user()->hasRole('company_admin')) {
            $companies = Company::where('id', auth()->user()->company_id)->get();
            $roles = Role::where('name', '!=', 'super_admin')
                ->orderBy('display_name')
                ->get();
        }
        
        return view('livewire.user-management.dashboard', [
            'companies' => $companies,
            'roles' => $roles,
        ]);
    }
}