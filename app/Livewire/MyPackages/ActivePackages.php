<?php

namespace App\Livewire\MyPackages;

use Livewire\Component;
use App\Models\Account;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class ActivePackages extends Component
{
    use WithPagination;

    public $sortBy = 'valid_until';
    public $sortDirection = 'asc';
    public $searchTerm = '';
    public $perPage = 9;

    public $packages=[];
    
    // Refresh data every 30 seconds
    public $refreshInterval = 30000;

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

    public function getPackagesProperty()
    {
        $query = Account::where('user_id', auth()->id())
                       ->where('company_id', auth()->user()->company_id)
                       ->validAccounts()
                       ->with(['payment', 'usageLogs' => function($q) {
                           $q->latest();
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

    public function getTotalRemainingReportsProperty()
    {
        return Account::getTotalRemainingReports(auth()->id(), auth()->user()->company_id);
    }

    public function getUsagePercentage($account)
    {
        if ($account->total_reports <= 0) return 0;
        return round((($account->total_reports - $account->remaining_reports) / $account->total_reports) * 100);
    }

    public function getDaysRemainingClass($daysRemaining)
    {
        if ($daysRemaining <= 7) return 'text-red-600';
        if ($daysRemaining <= 14) return 'text-yellow-600';
        return 'text-green-600';
    }

    public function refreshData()
    {
        $this->resetPage();
        $this->dispatch('refreshed');
    }

    public function render()
    {
        return view('livewire.my-packages.active-packages')->layout('layouts.app');
    }
}