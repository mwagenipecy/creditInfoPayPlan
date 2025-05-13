<div>
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Package Usage History</h1>
            <p class="text-gray-600">Analyze your report generation patterns and optimize your package usage.</p>
            @if($this->usageLogs->isEmpty())
                <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-blue-700 text-sm">
                            <strong>Demo Mode:</strong> No usage data found. Showing sample data for demonstration purposes.
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Summary Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm">Total Reports Used</p>
                        <p class="text-3xl font-bold">{{ number_format($this->usageSummary['total_reports']) }}</p>
                    </div>
                    <div class="bg-red-400 bg-opacity-30 p-3 rounded-full">
                        <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Active Days</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $this->usageSummary['unique_days'] }}</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Avg. Per Day</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $this->usageSummary['average_per_day'] }}</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Peak Usage Day</p>
                        @if($this->usageSummary['peak_day'])
                            <p class="text-lg font-bold text-gray-900">
                                {{ Carbon\Carbon::parse($this->usageSummary['peak_day']->date)->format('M d') }}
                            </p>
                            <p class="text-sm text-gray-600">{{ $this->usageSummary['peak_day']->daily_total }} reports</p>
                        @else
                            <p class="text-lg font-bold text-gray-900">N/A</p>
                        @endif
                    </div>
                    <div class="bg-yellow-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 mb-8">
            <div class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-40">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                    <select wire:model.live="selectedYear" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-red-500 focus:border-red-500">
                        @for($year = date('Y'); $year >= 2020; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>

                <div class="flex-1 min-w-40">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Month (Optional)</label>
                    <select wire:model.live="selectedMonth" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">All Months</option>
                        @for($month = 1; $month <= 12; $month++)
                            <option value="{{ $month }}">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                        @endfor
                    </select>
                </div>

                <div class="flex-1 min-w-40">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Package</label>
                    <select wire:model.live="selectedAccount" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">All Packages</option>
                        @foreach($this->availableAccounts as $account)
                            <option value="{{ $account->id }}">
                                {{ $account->account_number }} - {{ $account->package_type ?: 'Standard' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex space-x-2">
                    <button wire:click="setDateRange('month')" 
                        class="px-4 py-2 text-sm rounded-lg transition-colors duration-200 {{ $dateRange === 'month' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Monthly
                    </button>
                    <button wire:click="setDateRange('quarter')" 
                        class="px-4 py-2 text-sm rounded-lg transition-colors duration-200 {{ $dateRange === 'quarter' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Quarterly
                    </button>
                    <button wire:click="setDateRange('year')" 
                        class="px-4 py-2 text-sm rounded-lg transition-colors duration-200 {{ $dateRange === 'year' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Yearly
                    </button>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Usage Trend Chart -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Usage Trend</h3>
                    <div class="flex space-x-2">
                        <button wire:click="setChartType('line')" 
                            class="p-2 rounded-lg transition-colors duration-200 {{ $chartType === 'line' ? 'bg-red-100 text-red-600' : 'text-gray-400 hover:text-gray-600' }}">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </button>
                        <button wire:click="setChartType('bar')" 
                            class="p-2 rounded-lg transition-colors duration-200 {{ $chartType === 'bar' ? 'bg-red-100 text-red-600' : 'text-gray-400 hover:text-gray-600' }}">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="h-80 flex items-center justify-center" wire:ignore>
                    <canvas id="usageChart" style="width: 100%; height: 100%;"></canvas>
                </div>
            </div>

            <!-- Hourly Pattern Chart -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Hourly Usage Pattern</h3>
                <div class="h-80 flex items-center justify-center" wire:ignore>
                    <canvas id="hourlyChart" style="width: 100%; height: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Detailed Usage Logs -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Detailed Usage Log</h3>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $selectedYear }}{{ $selectedMonth ? ' - ' . date('F', mktime(0, 0, 0, $selectedMonth, 1)) : '' }}
                </p>
            </div>

            <div class="p-6">
            @if($this->usageLogs->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium text-gray-900">Date & Time</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-900">Package</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-900">Reports Used</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-900">Action Type</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-900">Remaining</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($this->usageLogs as $log)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-4 py-3">
                                            <div class="text-gray-900">{{ $log->used_at->format('M d, Y') }}</div>
                                            <div class="text-gray-500 text-xs">{{ $log->used_at->format('H:i:s') }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-gray-900">{{ $log->account->account_number }}</div>
                                            <div class="text-gray-500 text-xs">{{ $log->account->package_type ?: 'Standard' }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                {{ $log->reports_used }} report{{ $log->reports_used > 1 ? 's' : '' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-900">
                                            {{ ucfirst(str_replace('_', ' ', $log->action_type)) }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-900">
                                            {{ number_format($log->remaining_reports) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $this->usageLogs->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No usage data</h3>
                        <p class="mt-1 text-sm text-gray-500">No reports have been generated for the selected period.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Chart.js Integration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:init', function() {
            let usageChart = null;
            let hourlyChart = null;
            let chartInitialized = false;

            function initializeCharts() {
                // Check if elements exist
                const usageChartElement = document.getElementById('usageChart');
                const hourlyChartElement = document.getElementById('hourlyChart');

                if (!usageChartElement || !hourlyChartElement) {
                    console.log('Chart elements not ready, retrying...');
                    setTimeout(initializeCharts, 100);
                    return;
                }

                try {
                    // Get data from the component
                    const chartData = @json($this->chartData->toArray());
                    const hourlyData = @json($this->hourlyPattern->toArray());
                    const chartType = @json($this->chartType);
                    const dateRange = @json($this->dateRange);
                    
                    // Destroy existing charts
                    if (usageChart) {
                        usageChart.destroy();
                        usageChart = null;
                    }
                    if (hourlyChart) {
                        hourlyChart.destroy();
                        hourlyChart = null;
                    }
                    
                    // Usage Trend Chart
                    const usageCtx = usageChartElement.getContext('2d');
                    
                    const labels = chartData.map(item => item.period_name);
                    const data = chartData.map(item => item.total_reports);
                    
                    usageChart = new Chart(usageCtx, {
                        type: chartType,
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Reports Used',
                                data: data,
                                backgroundColor: chartType === 'line' ? 'rgba(220, 38, 38, 0.1)' : 'rgba(220, 38, 38, 0.8)',
                                borderColor: 'rgb(220, 38, 38)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: chartType === 'line'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Number of Reports'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: dateRange.charAt(0).toUpperCase() + dateRange.slice(1)
                                    }
                                }
                            },
                            interaction: {
                                intersect: false,
                            }
                        }
                    });
                    
                    // Hourly Pattern Chart
                    const hourlyCtx = hourlyChartElement.getContext('2d');
                    
                    const hourlyLabels = Array.from({length: 24}, (_, i) => `${i}:00`);
                    const hourlyValues = Array.from({length: 24}, (_, i) => {
                        const found = hourlyData.find(item => item.hour === i);
                        return found ? found.total_reports : 0;
                    });
                    
                    hourlyChart = new Chart(hourlyCtx, {
                        type: 'bar',
                        data: {
                            labels: hourlyLabels,
                            datasets: [{
                                label: 'Reports Used',
                                data: hourlyValues,
                                backgroundColor: 'rgba(220, 38, 38, 0.8)',
                                borderColor: 'rgb(220, 38, 38)',
                                borderRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Number of Reports'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Hour of Day'
                                    }
                                }
                            },
                            interaction: {
                                intersect: false,
                            }
                        }
                    });
                    
                    chartInitialized = true;
                } catch (error) {
                    console.error('Error initializing charts:', error);
                }
            }

            // Initialize charts on DOM ready
            initializeCharts();
            
            // Listen for Livewire component updates
            Livewire.on('chartUpdated', () => {
                setTimeout(() => {
                    if (chartInitialized) {
                        initializeCharts();
                    }
                }, 100);
            });

            // Re-initialize charts after Livewire updates
            document.addEventListener('livewire:navigated', function() {
                setTimeout(initializeCharts, 200);
            });

            // Also listen for general updates
            document.addEventListener('livewire:updated', function() {
                setTimeout(initializeCharts, 100);
            });
        });
    </script>

</div>