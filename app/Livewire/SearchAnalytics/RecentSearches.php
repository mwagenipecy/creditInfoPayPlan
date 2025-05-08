<?php

namespace App\Livewire\SearchAnalytics;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SearchLog;
use Carbon\Carbon;

class RecentSearches extends Component
{
    use WithPagination;
    
    public $dateRange = 'last_7_days';
    public $searchType = 'all';
    public $searchTerm = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    public function mount()
    {
        $this->loadSearches();
    }
    
    public function loadSearches()
    {
        // Reset pagination when filters change
        $this->resetPage();
    }
    
    protected function getDateRange()
    {
        return match($this->dateRange) {
            'today' => [Carbon::today(), Carbon::today()->endOfDay()],
            'yesterday' => [Carbon::yesterday(), Carbon::yesterday()->endOfDay()],
            'last_7_days' => [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()],
            'last_30_days' => [Carbon::now()->subDays(29)->startOfDay(), Carbon::now()->endOfDay()],
            'current_month' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()->endOfDay()],
            default => [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()],
        };
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
    
    public function updatedDateRange()
    {
        $this->loadSearches();
    }
    
    public function updatedSearchType()
    {
        $this->loadSearches();
    }
    
    public function updatedSearchTerm()
    {
        $this->loadSearches();
    }
    
    public function updatedPerPage()
    {
        $this->loadSearches();
    }
    
    public function render()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        $query = SearchLog::with('user')
            ->whereBetween('created_at', [$startDate, $endDate]);
            
        if ($this->searchType !== 'all') {
            $query->where('search_type', $this->searchType);
        }
        
        if (!empty($this->searchTerm)) {
            $query->where('search_term', 'like', '%' . $this->searchTerm . '%');
        }
        
        $searches = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
            
        // Get available search types for the filter
        $searchTypes = SearchLog::distinct('search_type')->pluck('search_type');
        
        return view('livewire.search-analytics.recent-searches', [
            'searches' => $searches,
            'searchTypes' => $searchTypes
        ]);
    }
}