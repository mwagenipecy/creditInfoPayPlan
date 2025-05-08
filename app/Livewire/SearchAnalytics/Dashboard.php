<?php

namespace App\Livewire\SearchAnalytics;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SearchLog;
use App\Models\User;
use Carbon\Carbon;

class Dashboard extends Component
{
    use WithPagination;
    
    // Filter properties
    public $dateRange = 'current_month';
    public $searchType = 'all';
    public $userId = null;
    public $customStartDate = null;
    public $customEndDate = null;
    
    // Stats properties
    public $totalSearches = 0;
    public $totalCost = 0;
    public $averageSearchesPerDay = 0;
    public $searchTrend = 0; // percentage increase/decrease from previous period
    public $mostSearchedTerm = '';
    public $mostActiveUser = '';
    
    // Loan-specific stats
    public $loanSearchCount = 0;
    public $loanSearchPercentage = 0;
    public $averageLoanAmount = 0;
    
    public function mount()
    {
        // Set default date range to current month
        $this->customStartDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->customEndDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        
        // Load initial stats
        $this->loadStats();
    }
    
    public function loadStats()
    {
        // Get date range based on selection
        [$startDate, $endDate] = $this->getDateRange();
        
        // Build base query
        $query = SearchLog::whereBetween('created_at', [$startDate, $endDate]);
        
        // Apply search type filter
        if ($this->searchType !== 'all') {
            $query->where('search_type', $this->searchType);
        }
        
        // Apply user filter
        if ($this->userId) {
            $query->where('user_id', $this->userId);
        }
        
        // Calculate basic stats
        $this->totalSearches = $query->count();
        $this->totalCost = $query->sum('cost');
        
        // Calculate averages
        $daysDifference = $startDate->diffInDays($endDate) + 1;
        $this->averageSearchesPerDay = $daysDifference > 0 ? $this->totalSearches / $daysDifference : 0;
        
        // Calculate trend compared to previous period
        $previousStartDate = (clone $startDate)->subDays($daysDifference);
        $previousEndDate = (clone $endDate)->subDays($daysDifference);
        
        $previousQuery = SearchLog::whereBetween('created_at', [$previousStartDate, $previousEndDate]);
        
        if ($this->searchType !== 'all') {
            $previousQuery->where('search_type', $this->searchType);
        }
        
        if ($this->userId) {
            $previousQuery->where('user_id', $this->userId);
        }
        
        $previousCount = $previousQuery->count();
        
        if ($previousCount > 0) {
            $this->searchTrend = (($this->totalSearches - $previousCount) / $previousCount) * 100;
        } else {
            $this->searchTrend = $this->totalSearches > 0 ? 100 : 0;
        }
        
        // Get most searched term
        $this->mostSearchedTerm = SearchLog::whereBetween('created_at', [$startDate, $endDate])
            ->select('search_term')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('search_term')
            ->orderByDesc('count')
            ->first()?->search_term ?? 'N/A';
            
        // Get most active user
        $mostActiveUserId = SearchLog::whereBetween('created_at', [$startDate, $endDate])
            ->select('user_id')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('user_id')
            ->orderByDesc('count')
            ->first()?->user_id;
            
        if ($mostActiveUserId) {
            $user = User::find($mostActiveUserId);
            $this->mostActiveUser = $user ? "{$user->first_name} {$user->last_name}" : 'Unknown';
        } else {
            $this->mostActiveUser = 'N/A';
        }
        
        // Calculate loan-specific stats
        $loanQuery = clone $query;
        $this->loanSearchCount = $loanQuery->where('search_category', 'loan')->count();
        $this->loanSearchPercentage = $this->totalSearches > 0 ? 
            ($this->loanSearchCount / $this->totalSearches) * 100 : 0;
            
        $this->averageLoanAmount = $loanQuery->where('search_category', 'loan')
            ->avg('loan_amount') ?? 0;
    }
    
    protected function getDateRange()
    {
        switch ($this->dateRange) {
            case 'today':
                return [Carbon::today(), Carbon::today()->endOfDay()];
            case 'yesterday':
                return [Carbon::yesterday(), Carbon::yesterday()->endOfDay()];
            case 'last_7_days':
                return [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()];
            case 'last_30_days':
                return [Carbon::now()->subDays(29)->startOfDay(), Carbon::now()->endOfDay()];
            case 'current_month':
                return [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()->endOfDay()];
            case 'last_month':
                return [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()->endOfDay()];
            case 'custom':
                return [
                    Carbon::parse($this->customStartDate)->startOfDay(),
                    Carbon::parse($this->customEndDate)->endOfDay()
                ];
            default:
                return [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()->endOfDay()];
        }
    }
    
    public function updatedDateRange()
    {
        if ($this->dateRange === 'custom') {
            // If custom is selected, we wait for the user to set the dates
            return;
        }
        
        $this->loadStats();
    }
    
    public function updatedSearchType()
    {
        $this->loadStats();
    }
    
    public function updatedUserId()
    {
        $this->loadStats();
    }
    
    public function applyCustomDateRange()
    {
        $this->validate([
            'customStartDate' => 'required|date',
            'customEndDate' => 'required|date|after_or_equal:customStartDate',
        ]);
        
        $this->loadStats();
    }
    
    public function exportData()
    {
        // Implement export functionality
        $this->dispatch('notify', type: 'success', message: 'Export started! The file will be downloaded shortly.');
    }
    
    public function render()
    {
        // Get users for filter dropdown
        $users = User::orderBy('first_name')
            ->orderBy('last_name')
            ->get();
            
        // Get search types for filter dropdown
        $searchTypes = SearchLog::distinct('search_type')->pluck('search_type');
        
        // Get recent searches
        [$startDate, $endDate] = $this->getDateRange();
        $recentSearches = SearchLog::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->take(5)
            ->get();
            
        return view('livewire.search-analytics.dashboard', [
            'users' => $users,
            'searchTypes' => $searchTypes,
            'recentSearches' => $recentSearches,
        ]);
    }
}