<div class="min-h-screen bg-gray-50 p-2 sm:p-4 lg:p-6">
    


<div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-6 lg:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex-1">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 mr-2 sm:mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"/>
                        </svg>
                        Admin Dashboard
                    </h1>
                    <p class="text-sm sm:text-base text-gray-600 mt-1">Analytics and insights for payment and usage data</p>
                </div>
                
                <!-- Controls -->
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                    <div class="flex items-center space-x-2">
                        <label class="text-xs sm:text-sm font-medium text-gray-700 whitespace-nowrap">Time Period:</label>
                        <select wire:model.live="dateRange" class="px-2 sm:px-3 py-1.5 sm:py-2 border border-gray-300 rounded-lg text-xs sm:text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 min-w-[120px]">
                            <option value="7">Last 7 days</option>
                            <option value="30">Last 30 days</option>
                            <option value="90">Last 90 days</option>
                            <option value="365">Last year</option>
                        </select>
                    </div>
                    
                    <button wire:click="$refresh" class="px-3 sm:px-4 py-1.5 sm:py-2 bg-red-600 text-white rounded-lg text-xs sm:text-sm font-medium hover:bg-red-700 transition-colors flex items-center justify-center whitespace-nowrap">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Refresh
                    </button>
                </div>
            </div>
        </div>

        <!-- Overview Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-6 lg:mb-8">
            <!-- Total Revenue -->
            <div class="bg-white rounded-lg lg:rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 lg:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex-1 mb-2 sm:mb-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Total Revenue</p>
                        <p class="text-lg sm:text-2xl lg:text-3xl font-bold text-gray-900">TZS {{ number_format($overviewStats['total_revenue'], 0) }}</p>
                        @if(isset($comparison['growth']['revenue']))
                            <p class="text-xs sm:text-sm {{ $comparison['growth']['revenue'] >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                                {{ $comparison['growth']['revenue'] >= 0 ? '+' : '' }}{{ $comparison['growth']['revenue'] }}%
                            </p>
                        @endif
                    </div>
                    <div class="bg-red-50 p-2 sm:p-3 rounded-full flex-shrink-0 self-start sm:self-center">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 lg:w-8 lg:h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Payments -->
            <div class="bg-white rounded-lg lg:rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 lg:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex-1 mb-2 sm:mb-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Total Payments</p>
                        <p class="text-lg sm:text-2xl lg:text-3xl font-bold text-gray-900">{{ number_format($overviewStats['total_payments']) }}</p>
                        @if(isset($comparison['growth']['payments']))
                            <p class="text-xs sm:text-sm {{ $comparison['growth']['payments'] >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
                                {{ $comparison['growth']['payments'] >= 0 ? '+' : '' }}{{ $comparison['growth']['payments'] }}%
                            </p>
                        @endif
                    </div>
                    <div class="bg-red-50 p-2 sm:p-3 rounded-full flex-shrink-0 self-start sm:self-center">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 lg:w-8 lg:h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Accounts -->
            <div class="bg-white rounded-lg lg:rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 lg:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex-1 mb-2 sm:mb-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Active Accounts</p>
                        <p class="text-lg sm:text-2xl lg:text-3xl font-bold text-gray-900">{{ number_format($overviewStats['active_accounts']) }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">{{ number_format($overviewStats['total_companies']) }} companies</p>
                    </div>
                    <div class="bg-red-50 p-2 sm:p-3 rounded-full flex-shrink-0 self-start sm:self-center">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 lg:w-8 lg:h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Reports Generated -->
            <div class="bg-white rounded-lg lg:rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 lg:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex-1 mb-2 sm:mb-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Reports Generated</p>
                        <p class="text-lg sm:text-2xl lg:text-3xl font-bold text-gray-900">{{ number_format($overviewStats['reports_generated']) }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">{{ number_format($overviewStats['total_searches']) }} searches</p>
                    </div>
                    <div class="bg-red-50 p-2 sm:p-3 rounded-full flex-shrink-0 self-start sm:self-center">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 lg:w-8 lg:h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- IMPORTANT CHART - Full Width Daily Revenue -->
        <div class="mb-6 lg:mb-8">
            <div class="bg-white rounded-lg lg:rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6">
                    <div>
                        <h3 class="text-lg sm:text-xl lg:text-2xl font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            Daily Revenue Trend
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Primary revenue analytics</p>
                    </div>
                    <div class="text-xs sm:text-sm text-gray-500 bg-gray-50 px-2 sm:px-3 py-1 rounded-full">TZS Currency</div>
                </div>
                <div class="h-64 sm:h-80 lg:h-96">
                    <canvas id="dailyRevenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Secondary Important Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 lg:mb-8">
            <!-- Daily Payments Chart -->
            <div class="bg-white rounded-lg lg:rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Daily Payment Count</h3>
                    <div class="text-xs sm:text-sm text-gray-500">Transactions</div>
                </div>
                <div class="h-48 sm:h-64 lg:h-80">
                    <canvas id="dailyPaymentsChart"></canvas>
                </div>
            </div>

            <!-- Daily Usage Chart -->
            <div class="bg-white rounded-lg lg:rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Daily Usage</h3>
                    <div class="text-xs sm:text-sm text-gray-500">Reports</div>
                </div>
                <div class="h-48 sm:h-64 lg:h-80">
                    <canvas id="dailyUsageChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Network Performance - Full Width Important Chart -->
        <div class="mb-6 lg:mb-8">
            <div class="bg-white rounded-lg lg:rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6">
                    <div>
                        <h3 class="text-lg sm:text-xl lg:text-2xl font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                            </svg>
                            Network Performance Analysis
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Revenue breakdown by payment networks</p>
                    </div>
                    <div class="text-xs sm:text-sm text-gray-500 bg-gray-50 px-2 sm:px-3 py-1 rounded-full">Revenue by Network</div>
                </div>
                <div class="h-64 sm:h-80 lg:h-96">
                    <canvas id="networkPerformanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Regular Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 lg:mb-8">
            <!-- User Registrations Chart -->
            <div class="bg-white rounded-lg lg:rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">User Registrations</h3>
                    <div class="text-xs sm:text-sm text-gray-500">New Users</div>
                </div>
                <div class="h-48 sm:h-64 lg:h-80">
                    <canvas id="userRegistrationsChart"></canvas>
                </div>
            </div>

            <!-- Top Companies Chart -->
            <div class="bg-white rounded-lg lg:rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Top Companies</h3>
                    <div class="text-xs sm:text-sm text-gray-500">By Revenue</div>
                </div>
                <div class="h-48 sm:h-64 lg:h-80">
                    <canvas id="topCompaniesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Status Distribution Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            <!-- Payment Status Distribution -->
            <div class="bg-white rounded-lg lg:rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Payment Status</h3>
                    <div class="text-xs sm:text-sm text-gray-500">Distribution</div>
                </div>
                <div class="space-y-3 sm:space-y-4">
                    @foreach($paymentStatusDistribution as $status)
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 sm:w-4 sm:h-4 bg-red-600 rounded mr-2 sm:mr-3"></div>
                                    <span class="text-xs sm:text-sm font-medium text-gray-900 capitalize">{{ $status->status }}</span>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs sm:text-sm font-semibold text-gray-900">{{ number_format($status->count) }}</div>
                                    <div class="text-xs text-gray-500">TZS {{ number_format($status->amount) }}</div>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 sm:h-2">
                                <div class="bg-red-600 h-1.5 sm:h-2 rounded-full transition-all duration-500" style="width: {{ $overviewStats['total_payments'] > 0 ? ($status->count / $overviewStats['total_payments']) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Package Distribution -->
           
        </div>
    </div>

    <!-- Chart.js Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Red color scheme for all charts
        const redColors = {
            primary: '#DC2626',
            light: '#FEE2E2',
            dark: '#991B1B',
            gradient: ['#DC2626', '#EF4444', '#F87171', '#FCA5A5'],
            gradientBg: function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(220, 38, 38, 0.8)');
                gradient.addColorStop(1, 'rgba(220, 38, 38, 0.1)');
                return gradient;
            }
        };

        // Responsive chart defaults
        Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
        Chart.defaults.color = '#6B7280';
        Chart.defaults.plugins.legend.display = false;

        // Daily Revenue Chart (IMPORTANT - Full Width)
        const dailyRevenueCtx = document.getElementById('dailyRevenueChart').getContext('2d');
        const dailyRevenueData = @json($dailyRevenueData);
        
        new Chart(dailyRevenueCtx, {
            type: 'bar',
            data: {
                labels: dailyRevenueData.map(d => d.label),
                datasets: [{
                    label: 'Revenue (TZS)',
                    data: dailyRevenueData.map(d => d.value),
                    backgroundColor: redColors.primary,
                    borderColor: redColors.dark,
                    borderWidth: 1,
                    borderRadius: {
                        topLeft: 6,
                        topRight: 6,
                        bottomLeft: 0,
                        bottomRight: 0
                    },
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: redColors.primary,
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Revenue: TZS ' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6',
                            drawBorder: false
                        },
                        ticks: {
                            padding: 10,
                            callback: function(value) {
                                return 'TZS ' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            padding: 10
                        }
                    }
                }
            }
        });

        // Daily Payments Chart
        const dailyPaymentsCtx = document.getElementById('dailyPaymentsChart').getContext('2d');
        const dailyPaymentData = @json($dailyPaymentData);
        
        new Chart(dailyPaymentsCtx, {
            type: 'bar',
            data: {
                labels: dailyPaymentData.map(d => d.label),
                datasets: [{
                    label: 'Payments Count',
                    data: dailyPaymentData.map(d => d.value),
                    backgroundColor: redColors.primary,
                    borderColor: redColors.dark,
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6'
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Daily Usage Chart
        const dailyUsageCtx = document.getElementById('dailyUsageChart').getContext('2d');
        const dailyUsageData = @json($dailyUsageData);
        
        new Chart(dailyUsageCtx, {
            type: 'bar',
            data: {
                labels: dailyUsageData.map(d => d.label),
                datasets: [{
                    label: 'Reports Generated',
                    data: dailyUsageData.map(d => d.value),
                    backgroundColor: redColors.primary,
                    borderColor: redColors.dark,
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6'
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Network Performance Chart (IMPORTANT - Full Width)
        const networkPerformanceCtx = document.getElementById('networkPerformanceChart').getContext('2d');
        const networkPerformance = @json($networkPerformance);
        
        new Chart(networkPerformanceCtx, {
            type: 'bar',
            data: {
                labels: networkPerformance.map(n => n.network_type),
                datasets: [{
                    label: 'Revenue (TZS)',
                    data: networkPerformance.map(n => n.revenue),
                    backgroundColor: redColors.gradient,
                    borderColor: redColors.dark,
                    borderWidth: 1,
                    borderRadius: {
                        topLeft: 8,
                        topRight: 8,
                        bottomLeft: 0,
                        bottomRight: 0
                    },
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: redColors.primary,
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Revenue: TZS ' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6',
                            drawBorder: false
                        },
                        ticks: {
                            padding: 10,
                            callback: function(value) {
                                return 'TZS ' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            padding: 10
                        }
                    }
                }
            }
        });

        // User Registrations Chart
        const userRegistrationsCtx = document.getElementById('userRegistrationsChart').getContext('2d');
        const dailyUserData = @json($dailyUserData);
        
        new Chart(userRegistrationsCtx, {
            type: 'bar',
            data: {
                labels: dailyUserData.map(d => d.label),
                datasets: [{
                    label: 'New Users',
                    data: dailyUserData.map(d => d.value),
                    backgroundColor: redColors.primary,
                    borderColor: redColors.dark,
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6'
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Top Companies Chart
        const topCompaniesCtx = document.getElementById('topCompaniesChart').getContext('2d');
        const topCompanies = @json($topCompanies);
        
        new Chart(topCompaniesCtx, {
            type: 'bar',
            data: {
                labels: topCompanies.map(c => {
                    // Responsive label truncation
                    const maxLength = window.innerWidth < 640 ? 12 : (window.innerWidth < 1024 ? 15 : 20);
                    return c.company_name.length > maxLength ? 
                           c.company_name.substring(0, maxLength) + '...' : 
                           c.company_name;
                }),
                datasets: [{
                    label: 'Revenue (TZS)',
                    data: topCompanies.map(c => c.revenue),
                    backgroundColor: redColors.primary,
                    borderColor: redColors.dark,
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: redColors.primary,
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            title: function(context) {
                                return topCompanies[context[0].dataIndex].company_name;
                            },
                            label: function(context) {
                                return 'Revenue: TZS ' + context.parsed.x.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6'
                        },
                        ticks: {
                            callback: function(value) {
                                // Responsive tick formatting
                                if (window.innerWidth < 640) {
                                    return value > 1000000 ? (value/1000000).toFixed(1) + 'M' : 
                                           value > 1000 ? (value/1000).toFixed(0) + 'K' : value;
                                }
                                return 'TZS ' + value.toLocaleString();
                            }
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: window.innerWidth < 640 ? 10 : 12
                            }
                        }
                    }
                }
            }
        });

        // Listen for Livewire events to refresh charts
        window.addEventListener('refreshCharts', () => {
            setTimeout(() => {
                location.reload();
            }, 100);
        });

        // Handle window resize for responsive charts
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                Chart.helpers.each(Chart.instances, function(instance) {
                    instance.resize();
                });
            }, 100);
        });
    });

    // Auto-refresh every 5 minutes
    setInterval(function() {
        if (typeof Livewire !== 'undefined') {
            Livewire.dispatch('refreshDashboard');
        }
    }, 300000);
    </script>

    <!-- Enhanced Responsive Styles -->
    <style>
        /* Base responsive utilities */
        .chart-container {
            position: relative;
            width: 100%;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 2px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #DC2626;
            border-radius: 2px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #991B1B;
        }
        
        /* Enhanced card animations */
        .bg-white {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .bg-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Loading states */
        .chart-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(45deg, #f9fafb, #f3f4f6);
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }
        
        .chart-loading::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(220, 38, 38, 0.1), transparent);
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        
        /* Progress bar animations */
        .bg-red-600 {
            background-color: #DC2626;
            animation: progressFill 1s ease-out;
        }
        
        @keyframes progressFill {
            from { width: 0%; }
        }
        
        /* Responsive font scaling */
        @media (max-width: 640px) {
            .text-3xl { font-size: 1.5rem; }
            .text-2xl { font-size: 1.25rem; }
            .text-xl { font-size: 1.125rem; }
            .text-lg { font-size: 1rem; }
            
            /* Compact spacing for mobile */
            .p-6 { padding: 1rem; }
            .p-4 { padding: 0.75rem; }
            .gap-6 { gap: 1rem; }
            .gap-4 { gap: 0.75rem; }
            .mb-8 { margin-bottom: 1.5rem; }
            .mb-6 { margin-bottom: 1rem; }
        }
        
        @media (max-width: 480px) {
            .text-lg { font-size: 0.875rem; }
            .text-base { font-size: 0.8rem; }
            
            /* Extra compact for very small screens */
            .p-3 { padding: 0.5rem; }
            .gap-3 { gap: 0.5rem; }
        }
        
        /* Enhanced focus states for accessibility */
        select:focus,
        button:focus {
            outline: none;
            ring-width: 2px;
            ring-color: #DC2626;
            ring-opacity: 0.5;
        }
        
        /* Print styles */
        @media print {
            .bg-white {
                box-shadow: none !important;
                border: 1px solid #e5e7eb !important;
            }
            
            canvas {
                max-height: 300px !important;
            }
        }
        
        /* Dark mode support (if needed) */
        @media (prefers-color-scheme: dark) {
            .bg-gray-50 {
                background-color: #1f2937;
            }
            
            .bg-white {
                background-color: #374151;
                border-color: #4b5563;
            }
            
            .text-gray-900 {
                color: #f9fafb;
            }
            
            .text-gray-600 {
                color: #d1d5db;
            }
            
            .text-gray-500 {
                color: #9ca3af;
            }
        }
        
        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .bg-red-600 {
                background-color: #000;
            }
            
            .text-red-600 {
                color: #000;
            }
            
            .border-gray-100 {
                border-color: #000;
            }
        }
        
        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            .bg-white,
            .bg-red-600 {
                transition: none;
                animation: none;
            }
            
            .chart-loading::before {
                animation: none;
            }
        }
        
        /* Container max-width adjustments */
        .max-w-7xl {
            max-width: 80rem;
        }
        
        @media (max-width: 1536px) {
            .max-w-7xl {
                max-width: 72rem;
            }
        }
        
        @media (max-width: 1280px) {
            .max-w-7xl {
                max-width: 64rem;
            }
        }
        
        @media (max-width: 1024px) {
            .max-w-7xl {
                max-width: 56rem;
            }
        }
        
        @media (max-width: 768px) {
            .max-w-7xl {
                max-width: 100%;
                margin-left: 0;
                margin-right: 0;
            }
        }
        
        /* Loading indicator for Livewire */
        [wire\:loading] {
            opacity: 0.6;
            pointer-events: none;
        }
        
        [wire\:loading] .chart-container {
            position: relative;
        }
        
        [wire\:loading] .chart-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }
        
        /* Chart canvas responsive adjustments */
        canvas {
            max-width: 100% !important;
            height: auto !important;
        }
        
        /* Mobile-first grid improvements */
        @media (max-width: 640px) {
            .grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            
            .lg\:grid-cols-4 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            
            .lg\:grid-cols-2 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
        }
        
        /* Ensure consistent card heights */
        .grid > .bg-white {
            display: flex;
            flex-direction: column;
        }
        
        .grid > .bg-white > div:last-child {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    </style>
</div>