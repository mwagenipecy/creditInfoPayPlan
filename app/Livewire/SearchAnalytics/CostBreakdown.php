<?php

namespace App\Livewire\SearchAnalytics;

use Livewire\Component;
use App\Models\SearchLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CostBreakdown extends Component
{
    public $dateRange = 'current_month';
    public $customStartDate = null;
    public $customEndDate = null;
    public $breakdownBy = 'search_type';
    
    public $totalCost = 0;
    public $breakdownData = [];
    public $costTrend = 0;
    public $costPerDay = [];
    
    public function mount()
    {
        // Set default date range to current month
        $this->customStartDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->customEndDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        
        $this->loadCostData();
    }
    
    public function loadCostData()
    {
        // Get date range
        [$startDate, $endDate] = $this->getDateRange();
        
        // Calculate total cost for selected period
        $this->totalCost = SearchLog::whereBetween('created_at', [$startDate, $endDate])
            ->sum('cost');
            
        // Calculate cost breakdown by selected dimension
        $this->breakdownData = SearchLog::whereBetween('created_at', [$startDate, $endDate])
            ->select($this->breakdownBy, DB::raw('SUM(cost) as total_cost'), DB::raw('COUNT(*) as count'))
            ->groupBy($this->breakdownBy)
            ->orderByDesc('total_cost')
            ->get()
            ->map(function($item) {
                $percentage = $this->totalCost > 0 ? ($item->total_cost / $this->totalCost) * 100 : 0;
                
                return [
                    'name' => ucfirst($item->{$this->breakdownBy}),
                    'value' => $item->{$this->breakdownBy},
                    'total_cost' => $item->total_cost,
                    'count' => $item->count,
                    'percentage' => round($percentage, 1),
                    'cost_per_search' => $item->count > 0 ? $item->total_cost / $item->count : 0
                ];
            });
            
        // Calculate trend compared to previous period
        $daysDifference = $startDate->diffInDays($endDate) + 1;
        $previousStartDate = (clone $startDate)->subDays($daysDifference);
        $previousEndDate = (clone $endDate)->subDays($daysDifference);
        
        $previousCost = SearchLog::whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->sum('cost');
            
        if ($previousCost > 0) {
            $this->costTrend = (($this->totalCost - $previousCost) / $previousCost) * 100;
        } else {
            $this->costTrend = $this->totalCost > 0 ? 100 : 0;
        }
        
        // Get cost per day for chart
        $this->costPerDay = [];
        $period = new \DatePeriod(
            $startDate,
            new \DateInterval('P1D'),
            (clone $endDate)->addDay() // Include the end date
        );
        
        foreach ($period as $date) {
            $dayCost = SearchLog::whereDate('created_at', $date->format('Y-m-d'))
                ->sum('cost');
                
            $this->costPerDay[] = [
                'date' => $date->format('M d'),
                'cost' => $dayCost
            ];
        }
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
        
        $this->loadCostData();
    }
    
    public function updatedBreakdownBy()
    {
        $this->loadCostData();
    }
    
    public function applyCustomDateRange()
    {
        $this->validate([
            'customStartDate' => 'required|date',
            'customEndDate' => 'required|date|after_or_equal:customStartDate',
        ]);
        
        $this->loadCostData();
    }
    
    public function render()
    {
        return view('livewire.search-analytics.cost-breakdown');
    }
}