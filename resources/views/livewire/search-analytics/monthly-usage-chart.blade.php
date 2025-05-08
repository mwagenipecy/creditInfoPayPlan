<div>
<div class="bg-white shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Monthly Search Usage</h2>
        <div class="flex space-x-4">
            <!-- Date range selector -->
            <select wire:model.live="dateRange" class="bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="last_6_months">Last 6 Months</option>
                <option value="last_12_months">Last 12 Months</option>
                <option value="year_to_date">Year to Date</option>
            </select>
        </div>
    </div>
    
    <!-- Search Type Filters -->
    <div class="mb-6">
        <h3 class="text-sm font-medium text-gray-700 mb-2">Filter by Search Type:</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($searchTypes as $type)
                <label class="inline-flex items-center">
                    <input type="checkbox" wire:model.live="selectedTypes" value="{{ $type }}" class="form-checkbox h-4 w-4 text-blue-600">
                    <span class="ml-2 text-sm text-gray-700">{{ ucfirst($type) }}</span>
                </label>
            @endforeach
        </div>
    </div>
    
    <!-- Chart Container -->
    <div class="h-80">
        <canvas id="monthlyUsageChart"></canvas>
    </div>

    <!-- JavaScript for Chart.js -->
    <script>
        document.addEventListener('livewire:initialized', function () {
            let chart;
            
            function initChart() {
                const ctx = document.getElementById('monthlyUsageChart').getContext('2d');
                chart = new Chart(ctx, {
                    type: 'line',
                    data: @json($chartData),
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        }
                    }
                });
            }
            
            initChart();
            
            // Update chart when data changes
            @this.on('chartDataUpdated', (chartData) => {
                if (chart) {
                    chart.data = chartData;
                    chart.update();
                }
            });
            
            // Re-render chart on content changes
            document.addEventListener('livewire:update', function() {
                if (chart) {
                    chart.destroy();
                }
                initChart();
            });
        });
    </script>
</div>

</div>
