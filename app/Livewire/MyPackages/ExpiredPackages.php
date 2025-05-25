<?php

namespace App\Livewire\MyPackages;

use Livewire\Component;
use App\Models\Account;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class ExpiredPackages extends Component
{
    use WithPagination;

    public $sortBy = 'valid_until';
    public $sortDirection = 'desc';
    public $searchTerm = '';
    public $perPage = 9;
    public $showUsageDetails = [];
    
    protected $queryString = [
        'searchTerm' => ['except' => ''],
        'perPage' => ['except' => 9],
    ];

    protected $listeners = ['refreshed'];

    public function mount()
    {
        // Initialize component
    }

    public function updatingSearchTerm()
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

    public function toggleUsageDetails($packageId)
    {
        if (isset($this->showUsageDetails[$packageId])) {
            unset($this->showUsageDetails[$packageId]);
        } else {
            $this->showUsageDetails[$packageId] = true;
        }
    }

    public function refreshData()
    {
        $this->resetPage();
        $this->dispatch('refreshed');
    }

    // Get expired packages with proper pagination
    private function getExpiredPackages()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return Account::whereRaw('1 = 0')->paginate($this->perPage); // Empty paginated result
        }

        $query = Account::where('company_id', auth()->user()->company_id)
                       ->where(function($q) {
                           $q->where('status', 'expired')
                             ->orWhere('valid_until', '<=', now());
                       })
                       ->with(['payment', 'user', 'usageLogs' => function($q) {
                           $q->orderBy('used_at', 'desc')->limit(5);
                       }]);

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

    // Summary statistics methods
    private function getTotalExpired()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return 0;
        }

        return Account::where('company_id', auth()->user()->company_id)
                     ->where(function($q) {
                         $q->where('status', 'expired')
                           ->orWhere('valid_until', '<=', now());
                     })
                     ->count();
    }

    private function getTotalWastedCredits()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return 0;
        }

        return Account::where('company_id', auth()->user()->company_id)
                     ->where(function($q) {
                         $q->where('status', 'expired')
                           ->orWhere('valid_until', '<=', now());
                     })
                     ->sum('remaining_reports');
    }

    private function getTotalAmountSpent()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return 0;
        }

        return Account::where('company_id', auth()->user()->company_id)
                     ->where(function($q) {
                         $q->where('status', 'expired')
                           ->orWhere('valid_until', '<=', now());
                     })
                     ->sum('amount_paid');
    }

    private function getAverageUtilization()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return 0;
        }

        $expiredAccounts = Account::where('company_id', auth()->user()->company_id)
                                ->where(function($q) {
                                    $q->where('status', 'expired')
                                      ->orWhere('valid_until', '<=', now());
                                })
                                ->get();

        if ($expiredAccounts->isEmpty()) {
            return 0;
        }

        $totalReports = $expiredAccounts->sum('total_reports');
        $totalUsed = $expiredAccounts->sum(function($account) {
            return $account->total_reports - $account->remaining_reports;
        });

        return $totalReports > 0 ? round(($totalUsed / $totalReports) * 100, 1) : 0;
    }

    // Helper methods for the view
    public function getUsagePercentage($account)
    {
        if ($account->total_reports <= 0) return 0;
        return round((($account->total_reports - $account->remaining_reports) / $account->total_reports) * 100, 1);
    }

    public function getDaysExpiredAgo($account)
    {
        if (!$account->valid_until) return 0;
        return max(0, $account->valid_until->diffInDays(now()));
    }

    public function render()
    {
        return view('livewire.my-packages.expired-packages', [
            'expiredPackages' => $this->getExpiredPackages(),
            'totalExpired' => $this->getTotalExpired(),
            'totalWastedCredits' => $this->getTotalWastedCredits(),
            'totalAmountSpent' => $this->getTotalAmountSpent(),
            'averageUtilization' => $this->getAverageUtilization(),
        ]);
    }
}