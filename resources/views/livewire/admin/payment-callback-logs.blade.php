<div>
<div>
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Payment Callback Logs</h1>
                    <p class="text-gray-600 mt-1">Monitor and manage payment gateway callback processing</p>
                </div>
                <div class="flex items-center space-x-4">
                    <button wire:click="refreshData" 
                        class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-colors duration-200 flex items-center space-x-1">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>Refresh</span>
                    </button>
                    <button wire:click="bulkIgnoreUnmatched" 
                        onclick="return confirm('Are you sure you want to ignore all old unmatched callbacks?')"
                        class="px-4 py-2 bg-orange-50 hover:bg-orange-100 text-orange-600 rounded-lg transition-colors duration-200 text-sm font-medium">
                        Bulk Ignore Old
                    </button>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session()->has('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p class="text-green-700 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <p class="text-red-700 text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Callbacks</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($statistics['total_callbacks']) }}</p>
                        <p class="text-gray-400 text-xs mt-1">In selected period</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Unmatched</p>
                        <p class="text-3xl font-bold text-orange-600">{{ number_format($statistics['unmatched_callbacks']) }}</p>
                        <p class="text-gray-400 text-xs mt-1">Need attention</p>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-1.167-2.694-1.167-3.464 0L3.34 16c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Success Rate</p>
                        <p class="text-3xl font-bold {{ $statistics['success_rate'] >= 80 ? 'text-green-600' : ($statistics['success_rate'] >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $statistics['success_rate'] }}%
                        </p>
                        <p class="text-gray-400 text-xs mt-1">Processing success</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Match Rate</p>
                        <p class="text-3xl font-bold {{ $statistics['match_rate'] >= 80 ? 'text-green-600' : ($statistics['match_rate'] >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $statistics['match_rate'] }}%
                        </p>
                        <p class="text-gray-400 text-xs mt-1">Auto-matched</p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 items-end">
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input wire:model.live.debounce.300ms="searchTerm" 
                        type="text" 
                        placeholder="Order ID, Payment Ref, Transaction ID, IP..." 
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Callback Status</label>
                    <select wire:model.live="callbackStatusFilter" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="all">All Status</option>
                        <option value="success">Success</option>
                        <option value="failed">Failed</option>
                        <option value="pending">Pending</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="unknown">Unknown</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Processing Status</label>
                    <select wire:model.live="processingStatusFilter" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="all">All Status</option>
                        <option value="unmatched">Unmatched</option>
                        <option value="matched">Matched</option>
                        <option value="processed">Processed</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                    <input wire:model.live="dateFrom" 
                        type="date" 
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                    <input wire:model.live="dateTo" 
                        type="date" 
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="mt-4 flex items-center justify-between">
                <button wire:click="clearFilters" 
                    class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition-colors duration-200">
                    Clear Filters
                </button>
                
                <div class="flex items-center space-x-4">
                    <select wire:model.live="perPage" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="20">20 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div wire:loading.delay.short class="flex justify-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-blue-500 border-t-transparent"></div>
        </div>

        <!-- Callback Logs Table -->
        <div wire:loading.remove.delay class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-900">Callback Info</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-900">Status</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-900">Payment Details</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-900">Source</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-900">Received</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($callbackLogs as $log)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <!-- Callback Info -->
                                <td class="px-4 py-3">
                                    <div class="space-y-1">
                                        @if($log->order_id)
                                            <div class="font-medium text-gray-900">{{ $log->order_id }}</div>
                                        @else
                                            <div class="text-gray-400 text-xs">No Order ID</div>
                                        @endif
                                        
                                        @if($log->payment_reference)
                                            <div class="text-xs text-gray-600">Ref: {{ $log->payment_reference }}</div>
                                        @endif
                                        
                                        @if($log->transaction_id)
                                            <div class="text-xs text-gray-500">TX: {{ Str::limit($log->transaction_id, 20) }}</div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-4 py-3">
                                    <div class="space-y-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusBadgeClass($log->callback_status, 'callback') }}">
                                            {{ ucfirst($log->callback_status) }}
                                        </span>
                                        <br>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusBadgeClass($log->processing_status, 'processing') }}">
                                            {{ ucfirst($log->processing_status) }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Payment Details -->
                                <td class="px-4 py-3">
                                    <div class="space-y-1">
                                        @if($log->amount)
                                            <div class="font-medium text-gray-900">
                                                {{ $log->currency ?? 'TZS' }} {{ number_format($log->amount, 2) }}
                                            </div>
                                        @endif
                                        
                                        @if($log->payment_id)
                                            <div class="text-xs text-blue-600">Payment ID: {{ $log->payment_id }}</div>
                                        @else
                                            <div class="text-xs text-gray-400">No Payment Link</div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Source -->
                                <td class="px-4 py-3">
                                    <div class="text-xs text-gray-600">
                                        {{ $log->source_ip ?? 'Unknown IP' }}
                                    </div>
                                
                                @if($log->source)
                                    <div class="text-xs text-gray-500">Source: {{ $log->source }}</div>
                                @endif
                            </td>

                            <!-- Received -->
                            <td class="px-4 py-3">
                                <div class="text-xs text-gray-600">
                                    {{ $log->created_at->format('Y-m-d H:i:s') }}
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="viewDetails({{ $log->id }})" 
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        View
                                    </button>
                                    <button wire:click="ignoreCallback({{ $log->id }})" 
                                        onclick="return confirm('Are you sure you want to ignore this callback?')"
                                        class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        Ignore
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">
                                No callback logs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4">
            {{ $callbackLogs->links() }}
        </div>
    </div>
</div>
</div>
                                
 </div>
