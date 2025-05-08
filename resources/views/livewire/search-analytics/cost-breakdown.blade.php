<div class="bg-white shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Cost Analysis</h2>
        
        <div class="flex items-center space-x-4">
            <!-- Date Range Selector -->
            <select wire:model.live="dateRange" class="bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="today">Today</option>
                <option value="yesterday">Yesterday</option>
                <option value="last_7_days">Last 7 Days</option>
                <option value="last_30_days">Last 30 Days</option>
                <option value="current_month">Current Month</option>
                <option value="last_month">Last Month</option>
                <option value="custom">Custom Range</option>
            </select>
            
            <!-- Breakdown Dimension Selector -->
            <select wire:model.live="breakdownBy" class="bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="search_type">By Search Type</option>
                <option value="search_category">By Category</option>
                <option value="user_id">By User</option>
            </select>
        </div>
    </div>
    
    <!-- Custom Date Range Inputs (shown only when custom is selected) -->
    @if($dateRange === 'custom')
        <div class="flex items-center space-x-4 mb-6">
            <div>
                <label for="customStartDate" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" id="customStartDate" wire:model="customStartDate" class="bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="customEndDate" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" id="customEndDate" wire:model="customEndDate" class="bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="flex items-end">
                <button wire:click="applyCustomDateRange" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Apply
                </button>
            </div>
        </div>
    @endif
    
    <!-- Total Cost Overview -->
    <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <div>
                <h3 class="text-sm font-medium text-blue-800 mb-1">Total Cost</h3>
                <p class="text-3xl font-bold text-blue-900">${{ number_format($totalCost, 2) }}</p>
            </div>
            
            <div class="mt-4 md:mt-0">
                <p class="text-sm text-gray-600">vs. Previous Period</p>
                <div class="flex items-center">
                    @if($costTrend > 0)
                        <span class="text-red-600 font-medium flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                            {{ number_format(abs($costTrend), 1) }}%
                        </span>
                    @elseif($costTrend < 0)
                        <span class="text-green-600 font-medium flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            {{ number_format(abs($costTrend), 1) }}%
                        </span>
                    @else
                        <span class="text-gray-600 font-medium">No change</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Cost Breakdown -->
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Cost Breakdown by {{ ucfirst(str_replace('_', ' ', $breakdownBy)) }}</h3>
            
            @if(count($breakdownData) > 0)
                <div class="space-y-4">
                    @foreach($breakdownData as $item)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium">{{ $item['name'] }}</span>
                                <span>${{ number_format($item['total_cost'], 2) }} ({{ $item['percentage'] }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $item['percentage'] }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>{{ $item['count'] }} searches</span>
                                <span>${{ number_format($item['cost_per_search'], 4) }} / search</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">No data available for the selected period.</p>
            @endif
        </div>
        
        <!-- Daily Cost Chart -->
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Daily Cost Trend</h3>
            
            @if(count($costPerDay) > 0)
                <div class="h-64">
                    <canvas id="dailyCostChart"></canvas>
                </div>
                
                <script>
                    document.addEventListener('livewire:initialized', function () {
                        let costChart;
                        
                        function initCostChart() {
                            const ctx = document.getElementById('dailyCostChart').getContext('2d');
                            
                            costChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: @json(array_column($costPerDay, 'date')),
                                    datasets: [{
                                        label: 'Daily Cost ($)',
                                        data: @json(array_column($costPerDay, 'cost')),
                                        borderColor: 'rgba(59, 130, 246, 1)',
                                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                        borderWidth: 2,
                                        fill: true,
                                        tension: 0.4
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                callback: function(value) {
                                                    return '$' + value.toFixed(2);
                                                }
                                            }
                                        }
                                    },
                                    plugins: {
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    return '$' + context.raw.toFixed(4);
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        }
                        
                        initCostChart();
                        
                        // Re-render chart on content changes
                        document.addEventListener('livewire:update', function() {
                            if (costChart) {
                                costChart.destroy();
                            }
                            initCostChart();
                        });
                    });
                </script>
            @else
                <p class="text-gray-500 italic">No data available for the selected period.</p>
            @endif
        </div>
    </div>
    
    <!-- Cost-saving Tips -->
    <div class="bg-green-50 border border-green-100 rounded-lg p-4">
        <h3 class="text-lg font-medium text-green-800 mb-2">Cost Optimization Tips</h3>
        <ul class="text-sm text-green-800 space-y-2">
            <li class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Use more specific search terms to reduce the number of searches needed.</span>
            </li>
            <li class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Consider implementing search result caching for frequently searched terms.</span>
            </li>
            <li class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Set search limits for users or departments with excessive usage.</span>
            </li>
        </ul>
    </div>
</div>