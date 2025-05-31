<div class="min-h-screen bg-gray-50 p-2 sm:p-4 lg:p-6">
    <div class="container mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 mr-2 sm:mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        Payment Callback Logs
                    </h1>
                    <p class="text-gray-600 mt-1 text-sm sm:text-base">Monitor and manage payment gateway callback processing</p>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center gap-2">
                    <button wire:click="exportCsv" 
                        class="px-3 py-2 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg transition-colors duration-200 flex items-center space-x-1 text-sm font-medium">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Export</span>
                    </button>
                    
                    <button wire:click="showRetryModal" 
                        class="px-3 py-2 bg-purple-50 hover:bg-purple-100 text-purple-600 rounded-lg transition-colors duration-200 flex items-center space-x-1 text-sm font-medium">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Auto Retry</span>
                    </button>
                    
                    <button wire:click="refreshData" 
                        class="px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-colors duration-200 flex items-center space-x-1 text-sm font-medium">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Refresh</span>
                    </button>
                    
                    <button wire:click="bulkIgnoreUnmatched" 
                        onclick="return confirm('Are you sure you want to ignore all old unmatched callbacks?')"
                        class="px-3 py-2 bg-orange-50 hover:bg-orange-100 text-orange-600 rounded-lg transition-colors duration-200 text-sm font-medium">
                        Bulk Ignore
                    </button>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session()->has('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <p class="text-green-700 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-red-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <p class="text-red-700 text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <!-- Total Callbacks -->
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-xs sm:text-sm font-medium">Total Callbacks</p>
                        <p class="text-xl sm:text-3xl font-bold text-gray-900">{{ number_format($statistics['total_callbacks']) }}</p>
                        <p class="text-gray-400 text-xs mt-1">In selected period</p>
                    </div>
                    <div class="bg-blue-50 p-2 sm:p-3 rounded-full flex-shrink-0">
                        <svg class="h-5 w-5 sm:h-8 sm:w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Unmatched -->
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-xs sm:text-sm font-medium">Unmatched</p>
                        <p class="text-xl sm:text-3xl font-bold text-orange-600">{{ number_format($statistics['unmatched_callbacks']) }}</p>
                        <p class="text-gray-400 text-xs mt-1">Need attention</p>
                    </div>
                    <div class="bg-orange-50 p-2 sm:p-3 rounded-full flex-shrink-0">
                        <svg class="h-5 w-5 sm:h-8 sm:w-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-1.167-2.694-1.167-3.464 0L3.34 16c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Success Rate -->
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-xs sm:text-sm font-medium">Success Rate</p>
                        <p class="text-xl sm:text-3xl font-bold {{ $statistics['success_rate'] >= 80 ? 'text-green-600' : ($statistics['success_rate'] >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $statistics['success_rate'] }}%
                        </p>
                        <p class="text-gray-400 text-xs mt-1">Processing success</p>
                    </div>
                    <div class="bg-green-50 p-2 sm:p-3 rounded-full flex-shrink-0">
                        <svg class="h-5 w-5 sm:h-8 sm:w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Match Rate -->
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-xs sm:text-sm font-medium">Match Rate</p>
                        <p class="text-xl sm:text-3xl font-bold {{ $statistics['match_rate'] >= 80 ? 'text-green-600' : ($statistics['match_rate'] >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $statistics['match_rate'] }}%
                        </p>
                        <p class="text-gray-400 text-xs mt-1">Auto-matched</p>
                    </div>
                    <div class="bg-purple-50 p-2 sm:p-3 rounded-full flex-shrink-0">
                        <svg class="h-5 w-5 sm:h-8 sm:w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Filters</h2>
            
            <!-- Filter Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                <!-- Search -->
                <div class="xl:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="searchTerm" 
                            type="text" 
                            placeholder="Order ID, Payment Ref, Transaction ID, IP..." 
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                </div>

                <!-- Callback Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Callback Status</label>
                    <select wire:model.live="callbackStatusFilter" 
                        class="w-full py-2.5 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="all">All Status</option>
                        <option value="success">Success</option>
                        <option value="failed">Failed</option>
                        <option value="pending">Pending</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="unknown">Unknown</option>
                    </select>
                </div>

                <!-- Processing Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Processing Status</label>
                    <select wire:model.live="processingStatusFilter" 
                        class="w-full py-2.5 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="all">All Status</option>
                        <option value="unmatched">Unmatched</option>
                        <option value="matched">Matched</option>
                        <option value="processed">Processed</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                    <input wire:model.live="dateFrom" 
                        type="date" 
                        class="w-full py-2.5 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>

                <!-- Date To -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date To</label>
                    <input wire:model.live="dateTo" 
                        type="date" 
                        class="w-full py-2.5 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
            </div>
            
            <!-- Filter Actions -->
            <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <button wire:click="clearFilters" 
                    class="inline-flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Clear All Filters
                </button>
                
                <div class="flex items-center gap-4">
                    <label class="text-sm text-gray-700">Per page:</label>
                    <select wire:model.live="perPage" 
                        class="py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div wire:loading class="flex justify-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-blue-500 border-t-transparent"></div>
        </div>

        <!-- Desktop Table View -->
        <div wire:loading.remove class="hidden lg:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Callback Info
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Payment Details
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Source Info
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Timestamp
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($callbackLogs as $log)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <!-- Callback Info -->
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        @if($log->order_id)
                                            <div class="font-medium text-gray-900">{{ $log->order_id }}</div>
                                        @else
                                            <div class="text-gray-400 text-xs italic">No Order ID</div>
                                        @endif
                                        
                                        @if($log->payment_reference)
                                            <div class="text-xs text-gray-600">Ref: {{ $log->payment_reference }}</div>
                                        @endif
                                        
                                        @if($log->transaction_id)
                                            <div class="text-xs text-gray-500 font-mono">TX: {{ Str::limit($log->transaction_id, 20) }}</div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <div class="space-y-2">
                                        <div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusBadgeClass($log->callback_status, 'callback') }}">
                                                {{ ucfirst($log->callback_status) }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusBadgeClass($log->processing_status, 'processing') }}">
                                                {{ ucfirst($log->processing_status) }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Payment Details -->
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        @if($log->amount)
                                            <div class="font-medium text-gray-900">
                                                {{ $log->currency ?? 'TZS' }} {{ number_format($log->amount, 2) }}
                                            </div>
                                        @else
                                            <div class="text-gray-400 text-xs">No amount</div>
                                        @endif
                                        
                                        @if($log->payment_id)
                                            <div class="text-xs">
                                                <span class="text-blue-600 hover:text-blue-800 cursor-pointer">
                                                    Payment #{{ $log->payment_id }}
                                                </span>
                                            </div>
                                        @else
                                            <div class="text-xs text-gray-400">No payment link</div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Source Info -->
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="text-xs text-gray-600 font-mono">
                                            {{ $log->source_ip ?? 'Unknown IP' }}
                                        </div>
                                        @if($log->source)
                                            <div class="text-xs text-gray-500">{{ $log->source }}</div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Timestamp -->
                                <td class="px-6 py-4">
                                    <div class="text-xs space-y-1">
                                        <div class="text-gray-900 font-medium">
                                            {{ $log->created_at->format('M j, Y') }}
                                        </div>
                                        <div class="text-gray-500">
                                            {{ $log->created_at->format('H:i:s') }}
                                        </div>
                                        <div class="text-gray-400">
                                            {{ $log->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex flex-col space-y-1">
                                        <button wire:click="viewDetails({{ $log->id }})" 
                                            class="inline-flex items-center text-blue-600 hover:text-blue-800 text-xs font-medium">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View Details
                                        </button>
                                        
                                        @if($log->processing_status === 'unmatched')
                                            <button wire:click="showProcessModal({{ $log->id }})" 
                                                class="inline-flex items-center text-green-600 hover:text-green-800 text-xs font-medium">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                Process
                                            </button>
                                        @endif
                                        
                                        @if($log->processing_status !== 'processed')
                                            <button wire:click="ignoreCallback({{ $log->id }})" 
                                                onclick="return confirm('Are you sure you want to ignore this callback?')"
                                                class="inline-flex items-center text-red-600 hover:text-red-800 text-xs font-medium">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Ignore
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No callback logs found</h3>
                                        <p class="text-gray-500">No callbacks match your current filter criteria.</p>
                                        <button wire:click="clearFilters" class="mt-4 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Clear filters to see all callbacks
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div wire:loading.remove class="lg:hidden space-y-4 mb-6">
            @forelse($callbackLogs as $log)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Card Header -->
                    <div class="p-4 border-b border-gray-100">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                @if($log->order_id)
                                    <h3 class="font-medium text-gray-900 text-sm">{{ $log->order_id }}</h3>
                                @else
                                    <h3 class="font-medium text-gray-400 text-sm italic">No Order ID</h3>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">{{ $log->created_at->format('M j, Y H:i') }}</p>
                            </div>
                            <div class="flex flex-col items-end space-y-2">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $this->getStatusBadgeClass($log->callback_status, 'callback') }}">
                                    {{ ucfirst($log->callback_status) }}
                                </span>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $this->getStatusBadgeClass($log->processing_status, 'processing') }}">
                                    {{ ucfirst($log->processing_status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4 space-y-3">
                        <!-- Amount -->
                        @if($log->amount)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Amount:</span>
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ $log->currency ?? 'TZS' }} {{ number_format($log->amount, 2) }}
                                </span>
                            </div>
                        @endif
                        
                        <!-- Payment Reference -->
                        @if($log->payment_reference)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Reference:</span>
                                <span class="text-sm text-gray-900 font-mono">{{ $log->payment_reference }}</span>
                            </div>
                        @endif
                        
                        <!-- Transaction ID -->
                        @if($log->transaction_id)
                            <div class="flex justify-between items-start">
                                <span class="text-sm text-gray-600">Transaction:</span>
                                <span class="text-sm text-gray-900 font-mono text-right break-all">
                                    {{ Str::limit($log->transaction_id, 30) }}
                                </span>
                            </div>
                        @endif
                        
                        <!-- Source IP -->
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Source IP:</span>
                            <span class="text-sm text-gray-900 font-mono">{{ $log->source_ip ?? 'Unknown' }}</span>
                        </div>
                        
                        <!-- Payment Link -->
                        @if($log->payment_id)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Payment:</span>
                                <span class="text-sm text-blue-600 font-medium">#{{ $log->payment_id }}</span>
                            </div>
                        @endif
                        
                        <!-- Processing Notes -->
                        @if($log->processing_notes)
                            <div class="pt-2 border-t border-gray-100">
                                <p class="text-xs text-gray-600 mb-1">Notes:</p>
                                <p class="text-xs text-gray-800">{{ Str::limit($log->processing_notes, 100) }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Card Actions -->
                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-100">
                        <div class="flex flex-wrap gap-2">
                            <button wire:click="viewDetails({{ $log->id }})" 
                                class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View
                            </button>
                            
                            @if($log->processing_status === 'unmatched')
                                <button wire:click="showProcessModal({{ $log->id }})" 
                                    class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Process
                                </button>
                            @endif
                            
                            @if($log->processing_status !== 'processed')
                                <button wire:click="ignoreCallback({{ $log->id }})" 
                                    onclick="return confirm('Are you sure you want to ignore this callback?')"
                                    class="inline-flex justify-center items-center px-3 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Ignore
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No callback logs found</h3>
                    <p class="text-gray-500 mb-4">No callbacks match your current filter criteria.</p>
                    <button wire:click="clearFilters" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Clear filters to see all callbacks
                    </button>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($callbackLogs->hasPages())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                {{ $callbackLogs->links() }}
            </div>
        @endif
    </div>

    <!-- Details Modal -->
    @if($showDetailsModal && $selectedLog)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeDetailsModal"></div>
                
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                
                <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                    <!-- Modal Header -->
                    <div class="bg-gray-50 px-4 py-3 sm:px-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Callback Details</h3>
                            <button wire:click="closeDetailsModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Modal Content -->
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 max-h-96 overflow-y-auto">
                        <!-- Basic Information -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Order ID</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $selectedLog->order_id ?: 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Payment Reference</label>
                                <p class="text-sm text-gray-900 font-mono break-all">{{ $selectedLog->payment_reference ?: 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Transaction ID</label>
                                <p class="text-sm text-gray-900 font-mono break-all">{{ $selectedLog->transaction_id ?: 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Amount</label>
                                <p class="text-sm font-bold text-gray-900">
                                    {{ $selectedLog->currency ?? 'TZS' }} {{ $selectedLog->amount ? number_format($selectedLog->amount, 2) : 'N/A' }}
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Callback Status</label>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $this->getStatusBadgeClass($selectedLog->callback_status, 'callback') }}">
                                    {{ ucfirst($selectedLog->callback_status) }}
                                </span>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Processing Status</label>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $this->getStatusBadgeClass($selectedLog->processing_status, 'processing') }}">
                                    {{ ucfirst($selectedLog->processing_status) }}
                                </span>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Source IP</label>
                                <p class="text-sm text-gray-900 font-mono">{{ $selectedLog->source_ip ?: 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Source</label>
                                <p class="text-sm text-gray-900">{{ $selectedLog->source ?: 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Received At</label>
                                <p class="text-sm text-gray-900">{{ $selectedLog->created_at->format('Y-m-d H:i:s') }}</p>
                            </div>
                            
                            @if($selectedLog->processed_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Processed At</label>
                                    <p class="text-sm text-gray-900">{{ $selectedLog->processed_at->format('Y-m-d H:i:s') }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Processing Notes -->
                        @if($selectedLog->processing_notes)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Processing Notes</label>
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                    <p class="text-sm text-blue-800">{{ $selectedLog->processing_notes }}</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Error Message -->
                        @if($selectedLog->error_message)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Error Message</label>
                                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                    <p class="text-sm text-red-800">{{ $selectedLog->error_message }}</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Linked Payment -->
                        @if($selectedLog->payment)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Linked Payment</label>
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                        <div>
                                            <span class="font-medium text-green-800">Payment ID:</span>
                                            <span class="text-green-700 ml-2">#{{ $selectedLog->payment->id }}</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-green-800">Order ID:</span>
                                            <span class="text-green-700 ml-2">{{ $selectedLog->payment->order_id }}</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-green-800">Amount:</span>
                                            <span class="text-green-700 ml-2">TZS {{ number_format($selectedLog->payment->amount, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-green-800">Status:</span>
                                            <span class="text-green-700 ml-2">{{ ucfirst($selectedLog->payment->status) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Raw Callback Data -->
                        @if($selectedLog->callback_data)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Raw Callback Data</label>
                                <div class="bg-gray-100 border border-gray-300 rounded-lg p-3 max-h-48 overflow-y-auto">
                                    <pre class="text-xs text-gray-800 font-mono whitespace-pre-wrap">{{ json_encode($selectedLog->callback_data, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        @if($selectedLog->processing_status === 'unmatched')
                            <button wire:click="showProcessModal({{ $selectedLog->id }})" 
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                Process Callback
                            </button>
                        @endif
                        <button wire:click="closeDetailsModal" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Process Modal -->
    @if($showProcessModal && $selectedLog)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeProcessModal"></div>
                
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                
                <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <!-- Modal Header -->
                    <div class="bg-gray-50 px-4 py-3 sm:px-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Process Callback</h3>
                            <button wire:click="closeProcessModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Modal Content -->
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <!-- Current Callback Info -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Callback Information</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                <div>
                                    <span class="font-medium text-gray-600">Order ID:</span>
                                    <span class="text-gray-800 ml-2">{{ $selectedLog->order_id ?: 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Reference:</span>
                                    <span class="text-gray-800 ml-2">{{ $selectedLog->payment_reference ?: 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Amount:</span>
                                    <span class="text-gray-800 ml-2">{{ $selectedLog->currency ?? 'TZS' }} {{ $selectedLog->amount ? number_format($selectedLog->amount, 2) : 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Status:</span>
                                    <span class="text-gray-800 ml-2">{{ ucfirst($selectedLog->callback_status) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Process Action Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Choose Action</label>
                            <div class="space-y-3">
                                <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                    <input type="radio" wire:model="processAction" value="match" class="mt-1 mr-3 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <div class="flex-1">
                                        <span class="text-sm font-medium text-gray-900">Match to Payment</span>
                                        <p class="text-xs text-gray-600 mt-1">Link this callback to an existing payment order</p>
                                    </div>
                                </label>
                                <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                    <input type="radio" wire:model="processAction" value="ignore" class="mt-1 mr-3 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <div class="flex-1">
                                        <span class="text-sm font-medium text-gray-900">Ignore Callback</span>
                                        <p class="text-xs text-gray-600 mt-1">Mark this callback as failed/ignored</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Manual Order ID Input -->
                        @if($processAction === 'match')
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Order ID to Match</label>
                                <input type="text" wire:model="manualOrderId" 
                                    placeholder="Enter the correct Order ID" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <p class="text-xs text-gray-600 mt-2">
                                    <svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    This will link the callback to the specified payment and update its status
                                </p>
                            </div>
                        @endif
                        
                        <!-- Processing Notes -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                            <textarea wire:model="processNotes" 
                                placeholder="Add any notes about this action..." 
                                rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none"></textarea>
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="processCallback" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            {{ $processAction === 'match' ? 'Match Payment' : 'Ignore Callback' }}
                        </button>
                        <button wire:click="closeProcessModal" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Retry Modal -->
   </div>