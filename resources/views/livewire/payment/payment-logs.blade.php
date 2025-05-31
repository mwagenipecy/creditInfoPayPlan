{{-- resources/views/livewire/payment-logs.blade.php --}}
<div class="min-h-screen bg-gray-50 p-2 sm:p-4 lg:p-6">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 mr-2 sm:mr-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"/>
                        </svg>
                        Payment Logs
                    </h1>
                    <p class="text-sm sm:text-base text-gray-600 mt-1">Track and monitor all payment transactions</p>
                </div>
                
                <!-- Summary Stats -->
                <div class="grid grid-cols-2 gap-3 sm:gap-4">
                    <div class="text-center">
                        <div class="text-lg sm:text-xl font-bold text-green-600">{{ $totalPayments ?? '0' }}</div>
                        <div class="text-xs sm:text-sm text-gray-500">Total</div>
                    </div>
                    <div class="text-center">
                        <div class="text-lg sm:text-xl font-bold text-red-600">TZS {{ number_format($totalAmount ?? 0) }}</div>
                        <div class="text-xs sm:text-sm text-gray-500">Amount</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900 mb-2 sm:mb-0">Filters</h2>
            <button wire:click="clearFilters" 
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Clear All
            </button>
        </div>
        
        <!-- Search Bar - Full width on mobile -->
        <div class="mb-4">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" wire:model.live="search" 
                       placeholder="Order ID, Mobile, Reference..." 
                       class="w-full pl-10 pr-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm sm:text-base">
            </div>
        </div>

        <!-- Filter Grid - Responsive -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="statusFilter" 
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                    <option value="failed">Failed</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="expired">Expired</option>
                </select>
            </div>

            <!-- Network Filter -->
            <div>
                <label for="network" class="block text-sm font-medium text-gray-700 mb-1">Network</label>
                <select wire:model.live="networkFilter" 
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
                    <option value="">All Networks</option>
                    <option value="MTN">MTN</option>
                    <option value="VODACOM">VODACOM</option>
                    <option value="AIRTEL">AIRTEL</option>
                    <option value="TIGO">TIGO</option>
                    <option value="TTCL">TTCL</option>
                    <option value="TPESA">TPESA</option>
                </select>
            </div>

            <!-- User Filter -->
            <div>
                <label for="user" class="block text-sm font-medium text-gray-700 mb-1">User</label>
                <select wire:model.live="userFilter" 
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Company Filter -->
            <div>
                <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                <select wire:model.live="companyFilter" 
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
                    <option value="">All Companies</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date From -->
            <div>
                <label for="dateFrom" class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                <input type="date" wire:model.live="dateFrom" 
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
            </div>

            <!-- Date To -->
            <div>
                <label for="dateTo" class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                <input type="date" wire:model.live="dateTo" 
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
            </div>

            <!-- Per Page -->
            <div>
                <label for="perPage" class="block text-sm font-medium text-gray-700 mb-1">Per Page</label>
                <select wire:model.live="perPage" 
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="all">All</option>
                </select>
            </div>

            <!-- Refresh Button -->
            <div class="flex items-end">
                <button wire:click="$refresh" 
                        class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Desktop Table View -->
    <div class="hidden lg:block bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Loading Indicator -->
        <div wire:loading class="flex justify-center items-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-red-600"></div>
        </div>

        <div wire:loading.remove class="overflow-x-auto">
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
                        <tr class="hover:bg-gray-50 transition-colors">
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
                                            $response = $payment->payment_response;
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
                                <button wire:click="showPaymentDetails({{ $payment->id }})" 
                                        class="text-red-600 hover:text-red-900 font-medium">
                                    View Details
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No payments found</h3>
                                <p class="mt-1 text-sm text-gray-500">No payments match your current filter criteria.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="lg:hidden space-y-4">
        <!-- Loading Indicator -->
        <div wire:loading class="flex justify-center items-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-red-600"></div>
        </div>

        <div wire:loading.remove>
            @forelse($payments as $payment)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $this->getNetworkBadgeClass($payment->network_type) }}">
                                {{ $payment->network_type }}
                            </span>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $this->getStatusBadgeClass($payment->status) }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                        <div class="text-lg font-bold text-gray-900">
                            TZS {{ number_format($payment->amount, 2) }}
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Order ID:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $payment->order_id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Mobile:</span>
                            <span class="text-sm text-gray-900">{{ $payment->mobile_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">User:</span>
                            <span class="text-sm text-gray-900">{{ $payment->user->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Company:</span>
                            <span class="text-sm text-gray-900">{{ $payment->company->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Created:</span>
                            <span class="text-sm text-gray-900">{{ $payment->created_at->format('M j, Y H:i') }}</span>
                        </div>
                        @if($payment->payment_reference)
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Reference:</span>
                                <span class="text-sm text-gray-900">{{ $payment->payment_reference }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Action Button -->
                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <button wire:click="showPaymentDetails({{ $payment->id }})" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View Details
                        </button>
                    </div>

                    <!-- Error Message for Failed Payments -->
                    @if($payment->status === 'failed' && $payment->payment_response)
                        @php
                            $response = $payment->payment_response;
                        @endphp
                        @if($response && isset($response['message']))
                            <div class="mt-3 p-2 bg-red-50 border border-red-200 rounded text-xs text-red-600">
                                {{ $response['message'] }}
                            </div>
                        @endif
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No payments found</h3>
                    <p class="mt-1 text-sm text-gray-500">No payments match your current filter criteria.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if(is_a($payments, 'Illuminate\Pagination\LengthAwarePaginator'))
        <div class="mt-6 bg-white rounded-lg shadow-sm p-4">
            {{ $payments->links() }}
        </div>
    @endif

    <!-- Payment Details Modal -->
    @if($showDetailsModal && $selectedPayment)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeDetailsModal"></div>
                
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                
                <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <!-- Modal Header -->
                    <div class="bg-gray-50 px-4 py-3 sm:px-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Payment Details</h3>
                            <button wire:click="closeDetailsModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Modal Content -->
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Order ID</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $selectedPayment->order_id }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Status</label>
                                    <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $this->getStatusBadgeClass($selectedPayment->status) }}">
                                        {{ ucfirst($selectedPayment->status) }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Amount</label>
                                    <p class="mt-1 text-sm font-bold text-gray-900">TZS {{ number_format($selectedPayment->amount, 2) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Network</label>
                                    <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $this->getNetworkBadgeClass($selectedPayment->network_type) }}">
                                        {{ $selectedPayment->network_type }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Mobile Number</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $selectedPayment->mobile_number }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Reference</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $selectedPayment->payment_reference ?: 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">User</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $selectedPayment->user->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Company</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $selectedPayment->company->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                            @if($selectedPayment->descriptions)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Description</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $selectedPayment->descriptions }}</p>
                                </div>
                            @endif
                            
                            @if($selectedPayment->payment_response)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Payment Response</label>
                                    <div class="mt-1 bg-gray-100 rounded p-3 text-xs text-gray-800 font-mono max-h-32 overflow-y-auto">
                                        {{ json_encode($selectedPayment->payment_response, JSON_PRETTY_PRINT) }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="closeDetailsModal" 
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>