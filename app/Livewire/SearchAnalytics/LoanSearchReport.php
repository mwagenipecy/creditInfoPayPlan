<?php

namespace App\Livewire\SearchAnalytics;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SearchLog;
use App\Models\User;
use Carbon\Carbon;

class LoanSearchReport extends Component
{
    use WithPagination;
    
    // Input parameters
    public $dateRange;
    public $userId;
    public $customStartDate;
    public $customEndDate;
    
    // Loan stats properties
    public $totalLoanSearches = 0;
    public $averageLoanAmount = 0;
    public $maxLoanAmount = 0;
    public $minLoanAmount = 0;
    public $medianLoanAmount = 0;
    public $loanAmountDistribution = [];
    public $topLoanSearchTerms = [];
    
    public function mount($dateRange = 'current_month', $userId = null, $customStartDate = null, $customEndDate = null)
    {
        $this->dateRange = $dateRange;
        $this->userId = $userId;
        $this->customStartDate = $customStartDate ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->customEndDate = $customEndDate ?? Carbon::now()->endOfMonth()->format('Y-m-d');
        
        $this->loadLoanStats();
    }
    
    public function loadLoanStats()
    {
        // Get date range
        [$startDate, $endDate] = $this->getDateRange();
        
        // Build base query
        $query = SearchLog::where('search_category', 'loan')
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        // Apply user filter if set
        if ($this->userId) {
            $query->where('user_id', $this->userId);
        }
        
        // Get total loan searches
        $this->totalLoanSearches = $query->count();
        
        // Calculate loan amount statistics
        $this->averageLoanAmount = round($query->avg('loan_amount') ?? 0, 2);
        $this->maxLoanAmount = $query->max('loan_amount') ?? 0;
        $this->minLoanAmount = $query->min('loan_amount') ?? 0;
        
        // Get loan amount distribution
        $loanAmounts = $query->pluck('loan_amount')->toArray();
        
        if (count($loanAmounts) > 0) {
            // Calculate median
            sort($loanAmounts);
            $count = count($loanAmounts);
            $middle = floor($count / 2);
            
            if ($count % 2 == 0) {
                $this->medianLoanAmount = ($loanAmounts[$middle - 1] + $loanAmounts[$middle]) / 2;
            } else {
                $this->medianLoanAmount = $loanAmounts[$middle];
            }
            
            // Create distribution buckets
            $min = $this->minLoanAmount;
            $max = $this->maxLoanAmount;
            $range = $max - $min;
            $bucketCount = 5; // Number of buckets for distribution
            
            if ($range > 0) {
                $bucketSize = $range / $bucketCount;
                $distribution = array_fill(0, $bucketCount, 0);
                
                foreach ($loanAmounts as $amount) {
                    $bucketIndex = min($bucketCount - 1, floor(($amount - $min) / $bucketSize));
                    $distribution[$bucketIndex]++;
                }
                
                $this->loanAmountDistribution = [];
                for ($i = 0; $i < $bucketCount; $i++) {
                    $lowerBound = $min + ($i * $bucketSize);
                    $upperBound = $min + (($i + 1) * $bucketSize);
                    $this->loanAmountDistribution[] = [
                        'range' => '$' . number_format($lowerBound, 0) . ' - $' . number_format($upperBound, 0),
                        'count' => $distribution[$i],
                        'percentage' => $this->totalLoanSearches > 0 ? round(($distribution[$i] / $this->totalLoanSearches) * 100, 1) : 0
                    ];
                }
            }
        }
        
        // Get top loan search terms
        $this->topLoanSearchTerms = SearchLog::where('search_category', 'loan')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('search_term')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('AVG(loan_amount) as avg_amount')
            ->groupBy('search_term')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->toArray();
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
    
    public function render()
    {
        // Get paginated loan searches
        [$startDate, $endDate] = $this->getDateRange();
        
        $loanSearches = SearchLog::with('user')
            ->where('search_category', 'loan')
            ->whereBetween('created_at', [$startDate, $endDate]);
            
        if ($this->userId) {
            $loanSearches->where('user_id', $this->userId);
        }
        
        $loanSearches = $loanSearches->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('livewire.search-analytics.loan-search-report', [
            'loanSearches' => $loanSearches
        ]);
    }
}