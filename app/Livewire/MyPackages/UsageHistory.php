<?php

namespace App\Livewire\MyPackages;

use Livewire\Component;
use App\Models\Account;
use App\Models\AccountUsageLog;
use App\Models\ReportLog;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsageHistory extends Component
{
    use WithPagination;

    public $selectedYear;
    public $selectedMonth = '';
    public $selectedAccount = '';
    public $perPage = 20;
    public $dateRange = 'month';
    public $chartType = 'line';
    
    protected $queryString = [
        'selectedYear' => ['except' => ''],
        'selectedMonth' => ['except' => ''],
        'selectedAccount' => ['except' => ''],
        'dateRange' => ['except' => 'month'],
    ];
    
    public function mount()
    {
        $this->selectedYear = date('Y');
    }

    public function updatedSelectedYear()
    {
        $this->resetPage();
        $this->dispatch('chartUpdated');
    }

    public function updatedSelectedMonth()
    {
        $this->resetPage();
        $this->dispatch('chartUpdated');
    }

    public function updatedSelectedAccount()
    {
        $this->resetPage();
        $this->dispatch('chartUpdated');
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    // Get usage data from account_usage_logs for charts
    private function getChartData()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return collect();
        }

        try {
            $query = DB::table('account_usage_logs')
                ->join('accounts', 'account_usage_logs.account_id', '=', 'accounts.id')
                ->where('accounts.company_id', auth()->user()->company_id)
                ->where('account_usage_logs.action_type', 'report_generation')
                ->whereYear('account_usage_logs.used_at', $this->selectedYear);

            if ($this->selectedMonth) {
                $query->whereMonth('account_usage_logs.used_at', $this->selectedMonth);
            }

            if ($this->selectedAccount) {
                $query->where('accounts.id', $this->selectedAccount);
            }

            switch ($this->dateRange) {
                case 'month':
                    $result = $query->select(
                        DB::raw('MONTH(account_usage_logs.used_at) as period'),
                        DB::raw('MONTHNAME(account_usage_logs.used_at) as period_name'),
                        DB::raw('SUM(account_usage_logs.reports_used) as total_reports')
                    )
                    ->groupBy('period', 'period_name')
                    ->orderBy('period')
                    ->get();
                    
                    // Fill missing months with zero
                    $months = collect();
                    for ($i = 1; $i <= 12; $i++) {
                        $existing = $result->firstWhere('period', $i);
                        $months->push((object)[
                            'period' => $i,
                            'period_name' => date('F', mktime(0, 0, 0, $i, 1)),
                            'total_reports' => $existing ? $existing->total_reports : 0
                        ]);
                    }
                    return $months;

                case 'quarter':
                    $result = $query->select(
                        DB::raw('QUARTER(account_usage_logs.used_at) as period'),
                        DB::raw('CONCAT("Q", QUARTER(account_usage_logs.used_at)) as period_name'),
                        DB::raw('SUM(account_usage_logs.reports_used) as total_reports')
                    )
                    ->groupBy('period', 'period_name')
                    ->orderBy('period')
                    ->get();
                    
                    // Fill missing quarters with zero
                    $quarters = collect();
                    for ($i = 1; $i <= 4; $i++) {
                        $existing = $result->firstWhere('period', $i);
                        $quarters->push((object)[
                            'period' => $i,
                            'period_name' => "Q{$i}",
                            'total_reports' => $existing ? $existing->total_reports : 0
                        ]);
                    }
                    return $quarters;

                default: // year
                    return $query->select(
                        DB::raw('YEAR(account_usage_logs.used_at) as period'),
                        DB::raw('YEAR(account_usage_logs.used_at) as period_name'),
                        DB::raw('SUM(account_usage_logs.reports_used) as total_reports')
                    )
                    ->groupBy('period', 'period_name')
                    ->orderBy('period')
                    ->get();
            }
        } catch (\Exception $e) {
            \Log::error('Error getting chart data: ' . $e->getMessage());
            return collect();
        }
    }

    // Get hourly usage pattern from account_usage_logs
    private function getHourlyPattern()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return collect();
        }

        try {
            $query = DB::table('account_usage_logs')
                ->join('accounts', 'account_usage_logs.account_id', '=', 'accounts.id')
                ->where('accounts.company_id', auth()->user()->company_id)
                ->where('account_usage_logs.action_type', 'report_generation')
                ->whereYear('account_usage_logs.used_at', $this->selectedYear);

            if ($this->selectedMonth) {
                $query->whereMonth('account_usage_logs.used_at', $this->selectedMonth);
            }

            if ($this->selectedAccount) {
                $query->where('accounts.id', $this->selectedAccount);
            }

            return $query->select(
                DB::raw('HOUR(account_usage_logs.used_at) as hour'),
                DB::raw('SUM(account_usage_logs.reports_used) as total_reports')
            )
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();
        } catch (\Exception $e) {
            \Log::error('Error getting hourly pattern: ' . $e->getMessage());
            return collect();
        }
    }

    // Get detailed usage logs from account_usage_logs
    private function getUsageLogs()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return new \Illuminate\Pagination\LengthAwarePaginator([], 0, $this->perPage, 1);
        }

        try {
            $query = AccountUsageLog::with(['account' => function($q) {
                $q->select('id', 'account_number', 'package_type', 'company_id');
            }])
            ->whereHas('account', function($q) {
                $q->where('company_id', auth()->user()->company_id);
            })
            ->where('action_type', 'report_generation')
            ->whereYear('used_at', $this->selectedYear);

            if ($this->selectedMonth) {
                $query->whereMonth('used_at', $this->selectedMonth);
            }

            if ($this->selectedAccount) {
                $query->where('account_id', $this->selectedAccount);
            }

            return $query->latest('used_at')->paginate($this->perPage);
        } catch (\Exception $e) {
            \Log::error('Error getting usage logs: ' . $e->getMessage());
            return new \Illuminate\Pagination\LengthAwarePaginator([], 0, $this->perPage, 1);
        }
    }

    // Get available accounts from accounts table
    private function getAvailableAccounts()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return collect();
        }

        try {
            return Account::where('company_id', auth()->user()->company_id)
                ->whereHas('usageLogs', function($q) {
                    $q->where('action_type', 'report_generation')
                      ->whereYear('used_at', $this->selectedYear);
                })
                ->select('id', 'account_number', 'package_type')
                ->orderBy('account_number')
                ->get();
        } catch (\Exception $e) {
            \Log::error('Error getting available accounts: ' . $e->getMessage());
            return collect();
        }
    }

    // Get comprehensive usage summary from real database tables
    private function getUsageSummary()
    {
        if (!auth()->check() || !auth()->user()->company_id) {
            return [
                'total_reports_generated' => 0,
                'total_reports_purchased' => 0,
                'total_reports_remaining' => 0,
                'utilization_rate' => 0,
                'active_accounts' => 0,
                'total_investment' => 0,
                'unique_days' => 0,
                'average_per_day' => 0,
                'peak_day' => null,
                'most_active_account' => null,
                'total_unique_reports' => 0,
            ];
        }

        $companyId = auth()->user()->company_id;

        try {
            // Get usage data from account_usage_logs
            $usageQuery = DB::table('account_usage_logs')
                ->join('accounts', 'account_usage_logs.account_id', '=', 'accounts.id')
                ->where('accounts.company_id', $companyId)
                ->where('account_usage_logs.action_type', 'report_generation')
                ->whereYear('account_usage_logs.used_at', $this->selectedYear);

            if ($this->selectedAccount) {
                $usageQuery->where('accounts.id', $this->selectedAccount);
            }

            $totalReportsGenerated = $usageQuery->sum('account_usage_logs.reports_used');

            // Get account statistics
            $accountQuery = Account::where('company_id', $companyId);
            
            $totalReportsPurchased = $accountQuery->sum('total_reports');
            $totalReportsRemaining = $accountQuery->where('status', 'active')->sum('remaining_reports');
            $activeAccounts = $accountQuery->where('status', 'active')->count();
            $totalInvestment = $accountQuery->sum('amount_paid');

            // Calculate utilization rate
            $utilizationRate = $totalReportsPurchased > 0 
                ? round((($totalReportsPurchased - $totalReportsRemaining) / $totalReportsPurchased) * 100, 1) 
                : 0;

            // Get unique days with activity
            $uniqueDays = $usageQuery->select(DB::raw('DATE(account_usage_logs.used_at) as date'))
                ->distinct()
                ->count();

            $averagePerDay = $uniqueDays > 0 ? round($totalReportsGenerated / $uniqueDays, 2) : 0;

            // Get peak usage day
            $peakDay = $usageQuery->select(
                DB::raw('DATE(account_usage_logs.used_at) as date'),
                DB::raw('SUM(account_usage_logs.reports_used) as daily_total')
            )
            ->groupBy('date')
            ->orderBy('daily_total', 'desc')
            ->first();

            // Get most active account
            $mostActiveAccount = $usageQuery->select(
                'accounts.account_number',
                'accounts.package_type',
                DB::raw('SUM(account_usage_logs.reports_used) as total_used')
            )
            ->groupBy('accounts.id', 'accounts.account_number', 'accounts.package_type')
            ->orderBy('total_used', 'desc')
            ->first();

            // Get unique credit reports from report_logs
            $totalUniqueReports = DB::table('report_logs')
                ->join('users', 'report_logs.user_id', '=', 'users.id')
                ->where('users.company_id', $companyId)
                ->whereYear('report_logs.retrieved_at', $this->selectedYear)
                ->distinct('report_logs.creditinfo_id')
                ->count('report_logs.creditinfo_id');

            return [
                'total_reports_generated' => $totalReportsGenerated,
                'total_reports_purchased' => $totalReportsPurchased,
                'total_reports_remaining' => $totalReportsRemaining,
                'utilization_rate' => $utilizationRate,
                'active_accounts' => $activeAccounts,
                'total_investment' => $totalInvestment,
                'unique_days' => $uniqueDays,
                'average_per_day' => $averagePerDay,
                'peak_day' => $peakDay,
                'most_active_account' => $mostActiveAccount,
                'total_unique_reports' => $totalUniqueReports,
            ];
        } catch (\Exception $e) {
            \Log::error('Error getting usage summary: ' . $e->getMessage());
            return [
                'total_reports_generated' => 0,
                'total_reports_purchased' => 0,
                'total_reports_remaining' => 0,
                'utilization_rate' => 0,
                'active_accounts' => 0,
                'total_investment' => 0,
                'unique_days' => 0,
                'average_per_day' => 0,
                'peak_day' => null,
                'most_active_account' => null,
                'total_unique_reports' => 0,
            ];
        }
    }

    public function setDateRange($range)
    {
        $this->dateRange = $range;
        $this->dispatch('chartUpdated');
    }

    public function setChartType($type)
    {
        $this->chartType = $type;
        $this->dispatch('chartUpdated');
    }

    public function refreshData()
    {
        $this->resetPage();
        $this->dispatch('chartUpdated');
    }

    // Computed properties for Livewire
    public function getChartDataProperty()
    {
        return $this->getChartData();
    }

    public function getHourlyPatternProperty()
    {
        return $this->getHourlyPattern();
    }

    public function getUsageLogsProperty()
    {
        return $this->getUsageLogs();
    }

    public function getAvailableAccountsProperty()
    {
        return $this->getAvailableAccounts();
    }

    public function getUsageSummaryProperty()
    {
        return $this->getUsageSummary();
    }

    public function render()
    {
        return view('livewire.my-packages.usage-history', [
            'chartData' => $this->chartData,
            'hourlyPattern' => $this->hourlyPattern,
            'usageLogs' => $this->usageLogs,
            'availableAccounts' => $this->availableAccounts,
            'usageSummary' => $this->usageSummary,
            'hasRealData' => $this->usageLogs->count() > 0 || $this->chartData->sum('total_reports') > 0,
        ]);
    }
}