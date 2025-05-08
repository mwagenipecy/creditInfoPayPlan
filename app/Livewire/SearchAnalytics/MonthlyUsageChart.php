<?php

namespace App\Livewire\SearchAnalytics;

use Livewire\Component;
use App\Models\SearchLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MonthlyUsageChart extends Component
{
    public $dateRange = 'last_6_months';
    public $chartData = [];
    public $chartLabels = [];
    public $searchTypes = [];
    public $selectedTypes = [];
    
    public function mount()
    {
        // Get unique search types
        $this->searchTypes = SearchLog::distinct('search_type')
            ->pluck('search_type')
            ->toArray();
            
        // By default, select all search types
        $this->selectedTypes = $this->searchTypes;
        
        $this->loadChartData();
    }
    
    public function loadChartData()
    {
        // Determine date range
        $endDate = Carbon::now();
        $startDate = match($this->dateRange) {
            'last_6_months' => Carbon::now()->subMonths(5)->startOfMonth(),
            'last_12_months' => Carbon::now()->subMonths(11)->startOfMonth(),
            'year_to_date' => Carbon::now()->startOfYear(),
            default => Carbon::now()->subMonths(5)->startOfMonth(),
        };
        
        // Generate monthly periods
        $period = new \DatePeriod(
            $startDate,
            new \DateInterval('P1M'),
            $endDate
        );
        
        // Create labels
        $this->chartLabels = [];
        foreach ($period as $date) {
            $this->chartLabels[] = $date->format('M Y');
        }
        $this->chartLabels[] = $endDate->format('M Y');
        
        // Create datasets for each selected search type
        $datasets = [];
        
        if (empty($this->selectedTypes)) {
            $this->chartData = [
                'labels' => $this->chartLabels,
                'datasets' => [],
            ];
            return;
        }
        
        foreach ($this->selectedTypes as $type) {
            $data = [];
            $currentDate = clone $startDate;
            
            while ($currentDate <= $endDate) {
                $nextMonth = (clone $currentDate)->addMonth();
                
                $count = SearchLog::where('search_type', $type)
                    ->whereBetween('created_at', [
                        $currentDate->format('Y-m-d'),
                        $nextMonth > $endDate 
                            ? $endDate->format('Y-m-d 23:59:59') 
                            : $nextMonth->format('Y-m-d')
                    ])
                    ->count();
                
                $data[] = $count;
                $currentDate = $nextMonth;
            }
            
            // Generate a consistent color for this search type
            $hash = md5($type);
            $r = hexdec(substr($hash, 0, 2));
            $g = hexdec(substr($hash, 2, 2));
            $b = hexdec(substr($hash, 4, 2));
            
            $datasets[] = [
                'label' => $type,
                'data' => $data,
                'backgroundColor' => "rgba($r, $g, $b, 0.2)",
                'borderColor' => "rgba($r, $g, $b, 1)",
                'borderWidth' => 2,
                'pointBackgroundColor' => "rgba($r, $g, $b, 1)",
            ];
        }
        
        $this->chartData = [
            'labels' => $this->chartLabels,
            'datasets' => $datasets,
        ];
    }
    
    public function updatedDateRange()
    {
        $this->loadChartData();
    }
    
    public function updatedSelectedTypes()
    {
        $this->loadChartData();
    }
    
    public function render()
    {
        return view('livewire.search-analytics.monthly-usage-chart');
    }
}