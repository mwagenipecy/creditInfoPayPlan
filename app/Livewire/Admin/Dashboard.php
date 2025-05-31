<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Payment;
use App\Models\Account;
use App\Models\AccountUsageLog;
use App\Models\Company;
use App\Models\User;
use App\Models\SearchLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $dateRange = '30'; // Default to last 30 days
    public $selectedMetric = 'revenue'; // Default metric
    
    protected $listeners = ['refreshDashboard' => '$refresh'];

    public function mount()
    {
        // Initialize with default values
    }

    public function updatedDateRange()
    {
        $this->dispatch('refreshCharts');
    }

    public function updatedSelectedMetric()
    {
        $this->dispatch('refreshCharts');
    }

    // Get date range for queries
    private function getDateRange()
    {
        switch ($this->dateRange) {
            case '7':
                return [Carbon::now()->subDays(7), Carbon::now()];
            case '30':
                return [Carbon::now()->subDays(30), Carbon::now()];
            case '90':
                return [Carbon::now()->subDays(90), Carbon::now()];
            case '365':
                return [Carbon::now()->subDays(365), Carbon::now()];
            default:
                return [Carbon::now()->subDays(30), Carbon::now()];
        }
    }

    // Get overview statistics
    public function getOverviewStats()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        return [
            'total_revenue' => Payment::where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount'),
            'total_payments' => Payment::whereBetween('created_at', [$startDate, $endDate])->count(),
            'completed_payments' => Payment::where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'active_accounts' => Account::where('status', 'active')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'total_companies' => Company::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_users' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_searches' => SearchLog::whereBetween('created_at', [$startDate, $endDate])->count(),
            'reports_generated' => AccountUsageLog::whereBetween('created_at', [$startDate, $endDate])
                ->sum('reports_used'),
        ];
    }

    // Get daily revenue data for chart
    public function getDailyRevenueData()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        $data = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $this->fillMissingDates($data, $startDate, $endDate, 'total');
    }

    // Get daily payment count data for chart
    public function getDailyPaymentCountData()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        $data = Payment::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $this->fillMissingDates($data, $startDate, $endDate, 'count');
    }

    // Get daily usage data for chart
    public function getDailyUsageData()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        $data = AccountUsageLog::whereBetween('created_at', [$startDate, $endDate])
        ->selectRaw('DATE(created_at) as date, SUM(reports_used) as `usage`') // backticks!
        ->groupBy('date')
        ->orderBy('date')
        ->get();
    

        return $this->fillMissingDates($data, $startDate, $endDate, 'usage');
    }

    // Get daily user registrations
    public function getDailyUserRegistrations()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        $data = User::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as registrations')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $this->fillMissingDates($data, $startDate, $endDate, 'registrations');
    }

    // Get network performance data
    public function getNetworkPerformance()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        return Payment::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('network_type, COUNT(*) as count, SUM(amount) as revenue, 
                         AVG(CASE WHEN status = "completed" THEN 1 ELSE 0 END) * 100 as success_rate')
            ->groupBy('network_type')
            ->orderBy('revenue', 'desc')
            ->get();
    }

    // Get payment status distribution
    public function getPaymentStatusDistribution()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        return Payment::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as count, SUM(amount) as amount')
            ->groupBy('status')
            ->orderBy('count', 'desc')
            ->get();
    }

    // Get top companies by revenue
    public function getTopCompaniesByRevenue()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        return Payment::join('companies', 'payments.company_id', '=', 'companies.id')
            ->where('payments.status', 'completed')
            ->whereBetween('payments.created_at', [$startDate, $endDate])
            ->selectRaw('companies.company_name, SUM(payments.amount) as revenue, COUNT(payments.id) as payment_count')
            ->groupBy('companies.id', 'companies.company_name')
            ->orderBy('revenue', 'desc')
            ->limit(10)
            ->get();
    }

    // Get account package distribution
    public function getAccountPackageDistribution()
    {
        [$startDate, $endDate] = $this->getDateRange();
        
        return Account::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('package_type, COUNT(*) as count, SUM(amount_paid) as total_revenue')
            ->groupBy('package_type')
            ->orderBy('count', 'desc')
            ->get();
    }

    // Helper method to fill missing dates
    private function fillMissingDates($data, $startDate, $endDate, $valueField)
    {
        $result = [];
        $current = $startDate->copy();
        
        // Convert data to associative array for quick lookup
        $dataArray = [];
        foreach ($data as $item) {
            $dataArray[$item->date] = $item->$valueField;
        }
        
        while ($current <= $endDate) {
            $dateString = $current->format('Y-m-d');
            $result[] = [
                'date' => $dateString,
                'label' => $current->format('M j'),
                'value' => $dataArray[$dateString] ?? 0
            ];
            $current->addDay();
        }
        
        return $result;
    }

    // Get growth percentage
    public function getGrowthPercentage($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        
        return round((($current - $previous) / $previous) * 100, 1);
    }

    // Get previous period comparison
    public function getPreviousPeriodComparison()
    {
        [$currentStart, $currentEnd] = $this->getDateRange();
        $days = $currentStart->diffInDays($currentEnd);
        
        $previousStart = $currentStart->copy()->subDays($days);
        $previousEnd = $currentStart->copy()->subDay();
        
        $current = [
            'revenue' => Payment::where('status', 'completed')
                ->whereBetween('created_at', [$currentStart, $currentEnd])
                ->sum('amount'),
            'payments' => Payment::whereBetween('created_at', [$currentStart, $currentEnd])->count(),
            'users' => User::whereBetween('created_at', [$currentStart, $currentEnd])->count(),
            'searches' => SearchLog::whereBetween('created_at', [$currentStart, $currentEnd])->count(),
        ];
        
        $previous = [
            'revenue' => Payment::where('status', 'completed')
                ->whereBetween('created_at', [$previousStart, $previousEnd])
                ->sum('amount'),
            'payments' => Payment::whereBetween('created_at', [$previousStart, $previousEnd])->count(),
            'users' => User::whereBetween('created_at', [$previousStart, $previousEnd])->count(),
            'searches' => SearchLog::whereBetween('created_at', [$previousStart, $previousEnd])->count(),
        ];
        
        return [
            'current' => $current,
            'previous' => $previous,
            'growth' => [
                'revenue' => $this->getGrowthPercentage($current['revenue'], $previous['revenue']),
                'payments' => $this->getGrowthPercentage($current['payments'], $previous['payments']),
                'users' => $this->getGrowthPercentage($current['users'], $previous['users']),
                'searches' => $this->getGrowthPercentage($current['searches'], $previous['searches']),
            ]
        ];
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'overviewStats' => $this->getOverviewStats(),
            'dailyRevenueData' => $this->getDailyRevenueData(),
            'dailyPaymentData' => $this->getDailyPaymentCountData(),
            'dailyUsageData' => $this->getDailyUsageData(),
            'dailyUserData' => $this->getDailyUserRegistrations(),
            'networkPerformance' => $this->getNetworkPerformance(),
            'paymentStatusDistribution' => $this->getPaymentStatusDistribution(),
            'topCompanies' => $this->getTopCompaniesByRevenue(),
            'packageDistribution' => $this->getAccountPackageDistribution(),
            'comparison' => $this->getPreviousPeriodComparison(),
        ]);
    }
}