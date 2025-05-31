<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Account;
use App\Models\AccountUsageLog;
use App\Models\Company;
use App\Models\User;
use App\Models\SearchLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    protected $cachePrefix = 'dashboard_';
    protected $cacheDuration;

    public function __construct()
    {
        $this->cacheDuration = config('dashboard.cache_duration', 60);
    }

    public function getOverviewStats(Carbon $startDate, Carbon $endDate): array
    {
        $cacheKey = $this->cachePrefix . 'overview_' . $startDate->format('Y-m-d') . '_' . $endDate->format('Y-m-d');
        
        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($startDate, $endDate) {
            return [
                'total_revenue' => $this->getTotalRevenue($startDate, $endDate),
                'total_payments' => $this->getTotalPayments($startDate, $endDate),
                'completed_payments' => $this->getCompletedPayments($startDate, $endDate),
                'active_accounts' => $this->getActiveAccounts($startDate, $endDate),
                'total_companies' => $this->getTotalCompanies($startDate, $endDate),
                'total_users' => $this->getTotalUsers($startDate, $endDate),
                'total_searches' => $this->getTotalSearches($startDate, $endDate),
                'reports_generated' => $this->getReportsGenerated($startDate, $endDate),
                'success_rate' => $this->getSuccessRate($startDate, $endDate),
            ];
        });
    }

    public function getDailyMetrics(Carbon $startDate, Carbon $endDate, string $metric): array
    {
        $cacheKey = $this->cachePrefix . "daily_{$metric}_" . $startDate->format('Y-m-d') . '_' . $endDate->format('Y-m-d');
        
        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($startDate, $endDate, $metric) {
            switch ($metric) {
                case 'revenue':
                    return $this->getDailyRevenue($startDate, $endDate);
                case 'payments':
                    return $this->getDailyPayments($startDate, $endDate);
                case 'usage':
                    return $this->getDailyUsage($startDate, $endDate);
                case 'users':
                    return $this->getDailyUsers($startDate, $endDate);
                default:
                    return [];
            }
        });
    }

    private function getTotalRevenue(Carbon $startDate, Carbon $endDate): float
    {
        return Payment::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');
    }

    private function getTotalPayments(Carbon $startDate, Carbon $endDate): int
    {
        return Payment::whereBetween('created_at', [$startDate, $endDate])->count();
    }

    private function getCompletedPayments(Carbon $startDate, Carbon $endDate): int
    {
        return Payment::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }

    private function getActiveAccounts(Carbon $startDate, Carbon $endDate): int
    {
        return Account::where('status', 'active')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }

    private function getTotalCompanies(Carbon $startDate, Carbon $endDate): int
    {
        return Company::whereBetween('created_at', [$startDate, $endDate])->count();
    }

    private function getTotalUsers(Carbon $startDate, Carbon $endDate): int
    {
        return User::whereBetween('created_at', [$startDate, $endDate])->count();
    }

    private function getTotalSearches(Carbon $startDate, Carbon $endDate): int
    {
        return SearchLog::whereBetween('created_at', [$startDate, $endDate])->count();
    }

    private function getReportsGenerated(Carbon $startDate, Carbon $endDate): int
    {
        return AccountUsageLog::whereBetween('created_at', [$startDate, $endDate])
            ->sum('reports_used');
    }

    private function getSuccessRate(Carbon $startDate, Carbon $endDate): float
    {
        $total = $this->getTotalPayments($startDate, $endDate);
        $completed = $this->getCompletedPayments($startDate, $endDate);
        
        return $total > 0 ? round(($completed / $total) * 100, 2) : 0;
    }

    private function getDailyRevenue(Carbon $startDate, Carbon $endDate): array
    {
        $data = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $this->fillMissingDates($data, $startDate, $endDate, 'total');
    }

    private function getDailyPayments(Carbon $startDate, Carbon $endDate): array
    {
        $data = Payment::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $this->fillMissingDates($data, $startDate, $endDate, 'count');
    }

    private function getDailyUsage(Carbon $startDate, Carbon $endDate): array
    {
        $data = AccountUsageLog::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(reports_used) as usage')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $this->fillMissingDates($data, $startDate, $endDate, 'usage');
    }

    private function getDailyUsers(Carbon $startDate, Carbon $endDate): array
    {
        $data = User::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as registrations')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $this->fillMissingDates($data, $startDate, $endDate, 'registrations');
    }

    private function fillMissingDates($data, Carbon $startDate, Carbon $endDate, string $valueField): array
    {
        $result = [];
        $current = $startDate->copy();
        
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

    public function clearCache(): void
    {
        $keys = [
            'overview_stats',
            'daily_revenue',
            'daily_payments',
            'daily_usage',
            'daily_users',
            'network_performance',
            'top_companies',
        ];

        foreach ($keys as $key) {
            Cache::forget($this->cachePrefix . $key);
        }
    }
}
