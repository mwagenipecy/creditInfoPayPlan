<?php

namespace App\Livewire\MyPackages;

use Livewire\Component;
use App\Models\Account;
use App\Models\AccountUsageLog;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ActivePackages extends Component
{
    use WithPagination;

    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $searchTerm = '';
    public $perPage = 9;
    public $statusFilter = 'all';
    
    // Refresh data every 30 seconds
    public $refreshInterval = 30000;

    protected $queryString = [
        'searchTerm' => ['except' => ''],
        'perPage' => ['except' => 9],
        'statusFilter' => ['except' => 'all'],
    ];

    public function mount()
    {
        // Check and update expired accounts on component load
        $this->updateExpiredAccounts();
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        
        $this->sortBy = $field;
        $this->resetPage();
    }

    private function updateExpiredAccounts()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return;
        }

        $companyId = auth()->user()->company_id;

        // Update expired accounts
        $expiredAccounts = Account::where('company_id', $companyId)
            ->where('status', 'active')
            ->where('valid_until', '<=', now())
            ->get();

        foreach ($expiredAccounts as $account) {
            $account->update(['status' => 'expired']);
            
            // Log the expiration
            AccountUsageLog::create([
                'account_id' => $account->id,
                'reports_used' => 0,
                'remaining_reports' => $account->remaining_reports,
                'action_type' => 'account_closure',
                'metadata' => [
                    'closure_reason' => 'expiration_date_reached',
                    'valid_until' => $account->valid_until->toDateTimeString(),
                    'closed_by_system' => true,
                ],
                'used_at' => now(),
            ]);
        }
    }

    public function getPackagesProperty()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return Account::whereRaw('1 = 0')->paginate($this->perPage); // Return empty paginated collection
        }

        $query = Account::where('company_id', auth()->user()->company_id)
                       ->with(['payment', 'user', 'usageLogs' => function($q) {
                           $q->latest()->limit(5);
                       }]);

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            if ($this->statusFilter === 'active') {
                $query->where('status', 'active')->where('valid_until', '>', now());
            } else {
                $query->where('status', $this->statusFilter);
            }
        }

        // Apply search filter
        if (!empty($this->searchTerm)) {
            $query->where(function($q) {
                $q->where('account_number', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('package_type', 'like', '%' . $this->searchTerm . '%')
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->searchTerm . '%')
                               ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
                  });
            });
        }

        return $query->orderBy($this->sortBy, $this->sortDirection)
                     ->paginate($this->perPage);
    }

    public function getTotalRemainingReportsProperty()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return 0;
        }

        return Account::where('company_id', auth()->user()->company_id)
            ->where('status', 'active')
            ->where('valid_until', '>', now())
            ->sum('remaining_reports');
    }

    public function getTotalActiveAccountsProperty()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return 0;
        }

        return Account::where('company_id', auth()->user()->company_id)
            ->where('status', 'active')
            ->where('valid_until', '>', now())
            ->count();
    }

    public function getExpiringSoonCountProperty()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return 0;
        }

        return Account::where('company_id', auth()->user()->company_id)
            ->where('status', 'active')
            ->where('valid_until', '>', now())
            ->where('valid_until', '<=', now()->addDays(7))
            ->count();
    }

    public function getTotalAmountSpentProperty()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return 0;
        }

        return Account::where('company_id', auth()->user()->company_id)
            ->sum('amount_paid');
    }

    public function getUsagePercentage($account)
    {
        if ($account->total_reports <= 0) return 0;
        return round((($account->total_reports - $account->remaining_reports) / $account->total_reports) * 100, 1);
    }

    public function getDaysRemainingClass($daysRemaining)
    {
        if ($daysRemaining <= 3) return 'text-red-600';
        if ($daysRemaining <= 7) return 'text-yellow-600';
        return 'text-green-600';
    }

    public function getStatusBadgeClass($status)
    {
        return match($status) {
            'active' => 'bg-green-100 text-green-800',
            'inactive' => 'bg-gray-100 text-gray-800',
            'suspended' => 'bg-yellow-100 text-yellow-800',
            'expired' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function viewAccountDetails($accountId)
    {
        $this->dispatch('show-account-details', accountId: $accountId);
    }

    public function refreshData()
    {
        $this->updateExpiredAccounts();
        $this->resetPage();
        $this->dispatch('refreshed');
    }

    public function render()
    {
        return view('livewire.my-packages.active-packages', [
            'packages' => $this->packages,
            'totalActiveAccounts' => $this->totalActiveAccounts,
            'totalRemainingReports' => $this->totalRemainingReports,
            'expiringSoonCount' => $this->expiringSoonCount,
            'totalAmountSpent' => $this->totalAmountSpent,
        ]);
    }
}