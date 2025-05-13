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
    
    protected $listeners = ['refreshed'];

    public function mount()
    {
        // Initialize component
    }

    public function updatingSearchTerm()
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

    public function getExpiredPackagesProperty()
    {
        $query = Account::where('user_id', auth()->id())
                       ->where('company_id', auth()->user()->company_id ?? 1)
                       ->expired()
                       ->with(['payment', 'usageLogs' => function($q) {
                           $q->orderBy('used_at', 'desc')->limit(5);
                       }]);

        if ($this->searchTerm) {
            $query->where(function($q) {
                $q->where('account_number', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('package_type', 'like', '%' . $this->searchTerm . '%');
            });
        }

        return $query->orderBy($this->sortBy, $this->sortDirection)
                     ->paginate($this->perPage);
    }

    public function getTotalExpiredProperty()
    {
        return Account::where('user_id', auth()->id())
                     ->where('company_id', auth()->user()->company_id ?? 1)
                     ->expired()
                     ->count();
    }

    public function getTotalWastedCreditsProperty()
    {
        return Account::where('user_id', auth()->id())
                     ->where('company_id', auth()->user()->company_id ?? 1)
                     ->expired()
                     ->sum('remaining_reports');
    }

    public function getTotalAmountSpentProperty()
    {
        return Account::where('user_id', auth()->id())
                     ->where('company_id', auth()->user()->company_id ?? 1)
                     ->expired()
                     ->sum('amount_paid');
    }

    public function getUsagePercentage($account)
    {
        if ($account->total_reports <= 0) return 0;
        return round((($account->total_reports - $account->remaining_reports) / $account->total_reports) * 100);
    }

    public function getDaysExpiredAgo($account)
    {
        return $account->valid_until->diffInDays(now());
    }

    public function render()
    {
        return view('livewire.my-packages.expired-packages');
    }
}