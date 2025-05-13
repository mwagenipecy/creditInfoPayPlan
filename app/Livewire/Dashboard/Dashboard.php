<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;
use App\Models\Company;
use App\Models\Account;
use App\Models\Payment;
use App\Models\ReportLog;
use App\Models\SearchLog;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Dashboard extends Component
{
    public $stats = [];
    public $recentActivities = [];
    public $monthlyReports = [];
    public $paymentStats = [];
    public $systemStatus = [];

    public function mount()
    {
        $this->calculateStats();
        $this->getRecentActivities();
        $this->getMonthlyReports();
        $this->getPaymentStats();
        $this->getSystemStatus();
    }

    private function calculateStats()
    {
        // Active Users (users who logged in during the last 30 days)
        $activeUsers = User::whereNotNull('last_login_at')
            ->where('last_login_at', '>=', Carbon::now()->subDays(30))
            ->count();
        
        $previousMonthActiveUsers = User::whereNotNull('last_login_at')
            ->whereBetween('last_login_at', [Carbon::now()->subDays(60), Carbon::now()->subDays(30)])
            ->count();
        
        $activeUsersChange = $previousMonthActiveUsers > 0 
            ? (($activeUsers - $previousMonthActiveUsers) / $previousMonthActiveUsers) * 100 
            : 0;

        // New Companies this week
        $newCompanies = Company::where('created_at', '>=', Carbon::now()->subWeek())->count();
        $previousWeekCompanies = Company::whereBetween('created_at', [
            Carbon::now()->subWeeks(2), 
            Carbon::now()->subWeek()
        ])->count();
        
        $newCompaniesChange = $previousWeekCompanies > 0 
            ? (($newCompanies - $previousWeekCompanies) / $previousWeekCompanies) * 100 
            : 0;

        // Reports Generated in last 30 days
        $reportsGenerated = ReportLog::where('retrieved_at', '>=', Carbon::now()->subDays(30))->count();
        $previousMonthReports = ReportLog::whereBetween('retrieved_at', [
            Carbon::now()->subDays(60), 
            Carbon::now()->subDays(30)
        ])->count();
        
        $reportsChange = $previousMonthReports > 0 
            ? (($reportsGenerated - $previousMonthReports) / $previousMonthReports) * 100 
            : 0;

        // Account Usage (active accounts)
        $activeAccounts = Account::where('status', 'active')
            ->where('valid_until', '>', Carbon::now())
            ->count();

        $this->stats = [
            'active_users' => [
                'count' => $activeUsers,
                'change' => round($activeUsersChange, 1),
                'trend' => $activeUsersChange >= 0 ? 'up' : 'down'
            ],
            'new_companies' => [
                'count' => $newCompanies,
                'change' => round($newCompaniesChange, 1),
                'trend' => $newCompaniesChange >= 0 ? 'up' : 'down'
            ],
            'reports_generated' => [
                'count' => $reportsGenerated,
                'change' => round($reportsChange, 1),
                'trend' => $reportsChange >= 0 ? 'up' : 'down'
            ],
            'active_accounts' => [
                'count' => $activeAccounts,
                'status' => 'operational'
            ]
        ];
    }

    private function getRecentActivities()
    {
        $this->recentActivities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($activity) {
                return [
                    'user' => $activity->user ? $activity->user->name : 'System',
                    'action' => $activity->action,
                    'description' => $activity->description ?? $activity->action,
                    'time' => $activity->created_at,
                    'icon' => $this->getActivityIcon($activity->action)
                ];
            });
    }

    private function getActivityIcon($action)
    {
        $icons = [
            'login' => 'fas fa-sign-in-alt',
            'logout' => 'fas fa-sign-out-alt',
            'created' => 'fas fa-plus',
            'updated' => 'fas fa-edit',
            'deleted' => 'fas fa-trash',
            'report_generated' => 'fas fa-file-alt',
            'payment_completed' => 'fas fa-dollar-sign',
            'default' => 'fas fa-info-circle'
        ];

        foreach ($icons as $key => $icon) {
            if (stripos($action, $key) !== false) {
                return $icon;
            }
        }

        return $icons['default'];
    }

    private function getMonthlyReports()
    {
        $this->monthlyReports = ReportLog::select(
                DB::raw('MONTH(retrieved_at) as month'),
                DB::raw('YEAR(retrieved_at) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->where('retrieved_at', '>=', Carbon::now()->subYear())
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($report) {
                $date = Carbon::createFromDate($report->year, $report->month, 1);
                return [
                    'month' => $date->format('M Y'),
                    'count' => $report->count
                ];
            });
    }

    private function getPaymentStats()
    {
        $this->paymentStats = Payment::select(
                'status',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->groupBy('status')
            ->get()
            ->keyBy('status')
            ->map(function ($payment) {
                return [
                    'count' => $payment->count,
                    'total_amount' => number_format($payment->total_amount, 2)
                ];
            });
    }

    private function getSystemStatus()
    {
        $this->systemStatus = [
            'database' => 'operational',
            'api' => 'operational',
            'cache' => Cache::store()->getStore() ? 'operational' : 'warning',
            'queue' => 'operational',
            'last_checked' => Carbon::now()
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard', [
            'stats' => $this->stats,
            'recentActivities' => $this->recentActivities,
            'monthlyReports' => $this->monthlyReports,
            'paymentStats' => $this->paymentStats,
            'systemStatus' => $this->systemStatus
        ]);
    }
}