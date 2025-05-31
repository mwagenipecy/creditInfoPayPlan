<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Dashboard Configuration
    |--------------------------------------------------------------------------
    */

    'refresh_interval' => env('DASHBOARD_REFRESH_INTERVAL', 300), // 5 minutes in seconds
    
    'cache_duration' => env('DASHBOARD_CACHE_DURATION', 60), // 1 minute in seconds
    
    'chart_colors' => [
        'primary' => '#DC2626',
        'secondary' => '#EF4444',
        'success' => '#10B981',
        'warning' => '#F59E0B',
        'danger' => '#EF4444',
        'info' => '#3B82F6',
    ],
    
    'date_ranges' => [
        '7' => 'Last 7 days',
        '30' => 'Last 30 days',
        '90' => 'Last 90 days',
        '365' => 'Last year',
    ],
    
    'charts' => [
        'height' => 300,
        'responsive' => true,
        'maintain_aspect_ratio' => false,
    ],
    
    'pagination' => [
        'per_page' => 10,
        'max_per_page' => 100,
    ],
    
    'cache_keys' => [
        'overview_stats' => 'dashboard.overview_stats',
        'daily_revenue' => 'dashboard.daily_revenue',
        'daily_payments' => 'dashboard.daily_payments',
        'network_performance' => 'dashboard.network_performance',
        'top_companies' => 'dashboard.top_companies',
    ],
];
