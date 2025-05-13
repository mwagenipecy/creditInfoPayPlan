<div>
<div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900">Payment Logs</h3>
            <p class="mt-1 text-sm text-gray-600">Track and monitor all payment transactions</p>
        </div>

        <!-- Filters -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input type="text" wire:model.live="search" placeholder="Order ID, Mobile, Reference..." 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select wire:model.live="statusFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                    <option value="failed">Failed</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="expired">Expired</option>
                </select>
            </div>

            <div>
                <label for="network" class="block text-sm font-medium text-gray-700">Network</label>
                <select wire:model.live="networkFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">All Networks</option>
                    <option value="MTN">MTN</option>
                    <option value="VODACOM">VODACOM</option>
                    <option value="AIRTEL">AIRTEL</option>
                    <option value="TIGO">TIGO</option>
                    <option value="TTCL">TTCL</option>
                    <option value="TPESA">TPESA</option>
                </select>
            </div>

            <div>
                <label for="user" class="block text-sm font-medium text-gray-700">User</label>
                <select wire:model.live="userFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                <select wire:model.live="companyFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">All Companies</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="dateFrom" class="block text-sm font-medium text-gray-700">Date From</label>
                <input type="date" wire:model.live="dateFrom" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="dateTo" class="block text-sm font-medium text-gray-700">Date To</label>
                <input type="date" wire:model.live="dateTo" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="perPage" class="block text-sm font-medium text-gray-700">Per Page</label>
                <select wire:model.live="perPage" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="all">All</option>
                </select>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mb-4">
            <div class="flex space-x-2">
                <button wire:click="clearFilters" 
                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Clear Filters
                        </button>
                        <button wire:click="$refresh" 
                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Refresh
                        </button>
                    </div>
            </div>
        </div>

            <!-- Payments Table -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:p-6">
                    <!-- Loading indicator -->
                    <div wire:loading class="flex justify-center items-center py-4">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-500"></div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Payment Details
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Network & Amount
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User & Company
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Timestamps
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($payments as $payment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $payment->order_id }}</div>
                                            <div class="text-sm text-gray-500">{{ $payment->mobile_number }}</div>
                                            @if($payment->payment_reference)
                                                <div class="text-xs text-gray-400">Ref: {{ $payment->payment_reference }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $this->getNetworkBadgeClass($payment->network_type) }}">
                                                {{ $payment->network_type }}
                                            </span>
                                            <div class="mt-1 text-sm font-medium text-gray-900">
                                                TZS {{ number_format($payment->amount, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $this->getStatusBadgeClass($payment->status) }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                            @if($payment->status === 'failed' && $payment->payment_response)
                                                <div class="mt-1">
                                                    @php

                                                        $response = $payment->payment_response; // json_decode(, true);
                                                    @endphp
                                                    @if($response && isset($response['message']))
                                                        <span class="text-xs text-red-600" title="{{ $response['message'] }}">
                                                            {{ Str::limit($response['message'], 30) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $payment->user->name ?? 'N/A' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $payment->company->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                            <div>Created: {{ $payment->created_at->format('M j, Y H:i') }}</div>
                                            @if($payment->payment_initiated_at)
                                                <div>Initiated: {{ $payment->payment_initiated_at->format('M j, Y H:i') }}</div>
                                            @endif
                                            @if($payment->payment_completed_at)
                                                <div>Completed: {{ $payment->payment_completed_at->format('M j, Y H:i') }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium">
                                            <button onclick="showPaymentDetails({{ $payment->id }})" 
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No payments found matching your criteria.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if(is_a($payments, 'Illuminate\Pagination\LengthAwarePaginator'))
                        <div class="mt-4">
                            {{ $payments->links() }}
                        </div>
                    @endif
                </div>
            </div>
    </div>



<!-- Payment Details Modal -->
<div x-data="{ open: false, paymentDetails: {} }" x-init="window.showPaymentDetails = (id) => { fetchPaymentDetails(id); open = true; }">
    <div x-show="open" class="fixed inset-0 overflow-y-auto z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Payment Details
                            </h3>
                            <div class="mt-4 space-y-3">
                                <div><strong>Order ID:</strong> <span x-text="paymentDetails.order_id"> </span></div>
                                <div><strong>Mobile Number:</strong> <span x-text="paymentDetails.mobile_number"></span></div>
                                <div><strong>Amount:</strong> <span x-text="paymentDetails.amount"></span></div>
                                <div><strong>Status:</strong> <span x-text="paymentDetails.status"></span></div>
                                <div><strong>Network:</strong> <span x-text="paymentDetails.network_type"></span></div>
                                <div><strong>Payment Reference:</strong> <span x-text="paymentDetails.payment_reference || 'N/A'"></span></div>
                                <div><strong>Token Number:</strong> <span x-text="paymentDetails.token_number || 'N/A'"></span></div>
                                <div><strong>Device IP:</strong> <span x-text="paymentDetails.device_ip"></span></div>
                                <div><strong>Description:</strong> <span x-text="paymentDetails.descriptions"></span></div>
                                <div x-show="paymentDetails.payment_response">
                                    <strong>Payment Response:</strong> 
                                    <pre class="mt-1 text-xs bg-gray-100 p-2 rounded" x-text="paymentDetails.payment_response"></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click="open = false" type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Status Chart
        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            const statusData = @json($statusStats);
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(statusData).map(key => key.charAt(0).toUpperCase() + key.slice(1)),
                    datasets: [{
                        data: Object.values(statusData).map(item => item.count),
                        backgroundColor: [
                            '#10B981', // completed - green
                            '#EF4444', // failed - red
                            '#3B82F6', // processing - blue
                            '#F59E0B', // pending - yellow
                            '#6B7280', // cancelled - gray
                            '#F97316', // expired - orange
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }

        // Network Chart
        const networkCtx = document.getElementById('networkChart');
        if (networkCtx) {
            const networkData = @json($networkStats);
            new Chart(networkCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(networkData),
                    datasets: [{
                        label: 'Transactions',
                        data: Object.values(networkData).map(item => item.count),
                        backgroundColor: [
                            '#FEF3C7', // MTN - yellow
                            '#FEE2E2', // VODACOM - red
                            '#DBEAFE', // AIRTEL - blue
                            '#D1FAE5', // TIGO - green
                            '#E0E7FF', // TTCL - purple
                            '#EDE9FE', // TPESA - indigo
                        ],
                        borderColor: [
                            '#F59E0B',
                            '#EF4444',
                            '#3B82F6',
                            '#10B981',
                            '#8B5CF6',
                            '#6366F1',
                        ],
                        borderWidth: 1
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
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Hourly Trend Chart
        const hourlyCtx = document.getElementById('hourlyChart');
        if (hourlyCtx) {
            const hourlyData = @json($hourlyTrend);
            const hours = [];
            const counts = [];
            
            // Generate all hours from 00:00 to 23:00
            for (let i = 0; i < 24; i++) {
                const hour = i.toString().padStart(2, '0') + ':00';
                hours.push(hour);
                counts.push(hourlyData[hour] ? hourlyData[hour].count : 0);
            }
            
            new Chart(hourlyCtx, {
                type: 'line',
                data: {
                    labels: hours,
                    datasets: [{
                        label: 'Transactions',
                        data: counts,
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
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
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });

    function fetchPaymentDetails(id) {
        // Simulate API call to fetch payment details
        // In a real application, you would make an AJAX call to your backend
        fetch(`/api/payments/${id}`)
            .then(response => response.json())
            .then(data => {
                Alpine.store('paymentDetails', data);
            })
            .catch(error => {
                console.error('Error fetching payment details:', error);
            });
    }

    // Auto-refresh functionality
    setInterval(() => {
        if (window.livewire) {
            window.livewire.emit('refreshPayments');
        }
    }, 30000); // Refresh every 30 seconds
</script>

</div>
