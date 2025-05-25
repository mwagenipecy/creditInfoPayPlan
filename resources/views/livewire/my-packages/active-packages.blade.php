<div>
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Active Packages</h1>
                <p class="text-gray-600 mt-1">Manage and monitor your company's active credit report packages</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-sm text-gray-500 flex items-center">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Auto-refresh: {{ $refreshInterval / 1000 }}s
                </div>
                <button wire:click="refreshData" 
                    class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors duration-200 flex items-center space-x-1">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>Refresh</span>
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Total Reports Remaining</p>
                        <p class="text-3xl font-bold">{{ number_format($totalRemainingReports) }}</p>
                        <p class="text-red-200 text-xs mt-1">Across all active packages</p>
                    </div>
                    <div class="bg-red-400 bg-opacity-30 p-3 rounded-full">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Active Packages</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($totalActiveAccounts) }}</p>
                        <p class="text-gray-400 text-xs mt-1">Currently in use</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Expiring Soon</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($expiringSoonCount) }}</p>
                        <p class="text-gray-400 text-xs mt-1">Within 7 days</p>
                    </div>
                    <div class="bg-yellow-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-1.167-2.694-1.167-3.464 0L3.34 16c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Investment</p>
                        <p class="text-3xl font-bold text-gray-900">TZS {{ number_format($totalAmountSpent) }}</p>
                        <p class="text-gray-400 text-xs mt-1">Total spent</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
            <div class="relative flex-1 max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="searchTerm" 
                    type="text" 
                    placeholder="Search by account number, package type, or user..." 
                    class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg bg-white shadow-sm text-gray-900 placeholder-gray-500 focus:ring-red-500 focus:border-red-500">
            </div>

            <div class="flex items-center space-x-4">
                <select wire:model.live="statusFilter" class="border border-gray-200 bg-white rounded-lg px-3 py-2 text-gray-700 focus:ring-red-500 focus:border-red-500">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="expired">Expired</option>
                    <option value="suspended">Suspended</option>
                </select>

                <select wire:model.live="perPage" class="border border-gray-200 bg-white rounded-lg px-3 py-2 text-gray-700 focus:ring-red-500 focus:border-red-500">
                    <option value="9">9 per page</option>
                    <option value="18">18 per page</option>
                    <option value="27">27 per page</option>
                    <option value="50">50 per page</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Loading State -->
    <div wire:loading.delay.short class="flex justify-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-red-500 border-t-transparent"></div>
    </div>

    <!-- Packages Grid -->
    <div wire:loading.remove.delay class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($packages as $package)
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <!-- Package Header -->
                <div class="bg-gradient-to-r from-red-50 to-red-100 p-6 border-b border-red-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $package->package_type ?: 'Standard Package' }}</h3>
                            <p class="text-sm text-gray-600 font-mono">{{ $package->account_number }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $package->user->name ?? 'N/A' }}</p>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusBadgeClass($package->status) }}">
                                {{ ucfirst($package->status) }}
                            </span>
                            @if($package->status === 'active' && $package->daysRemaining() <= 7)
                                <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2 py-0.5 rounded-full">
                                    {{ $package->daysRemaining() }}d left
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Package Content -->
                <div class="p-6 space-y-4">
                    <!-- Reports Progress -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Reports Usage</span>
                            <span class="text-sm text-gray-600 font-medium">
                                {{ $package->total_reports - $package->remaining_reports }}/{{ $package->total_reports }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-gradient-to-r from-red-500 to-red-600 h-3 rounded-full transition-all duration-500 relative" 
                                style="width: {{ $this->getUsagePercentage($package) }}%">
                                @if($this->getUsagePercentage($package) > 10)
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-white text-xs font-medium">{{ $this->getUsagePercentage($package) }}%</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>{{ $package->remaining_reports }} remaining</span>
                            <span>{{ $this->getUsagePercentage($package) }}% used</span>
                        </div>
                    </div>

                    <!-- Time Information -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500">Days Left</p>
                                <p class="text-sm font-semibold {{ $this->getDaysRemainingClass($package->daysRemaining()) }}">
                                    {{ $package->daysRemaining() }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500">Amount</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    TZS {{ number_format($package->amount_paid) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Purchase Details -->
                    <div class="border-t border-gray-100 pt-4">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500 text-xs">Purchased</p>
                                <p class="font-medium text-gray-900">{{ $package->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs">Expires</p>
                                <p class="font-medium text-gray-900">{{ $package->valid_until->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Last Used -->
                    @if($package->last_used)
                        <div class="flex items-center text-sm text-gray-500 border-t border-gray-100 pt-3">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-xs">Last used {{ $package->last_used->diffForHumans() }}</span>
                        </div>
                    @else
                        <div class="flex items-center text-sm text-gray-400 border-t border-gray-100 pt-3">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                            <span class="text-xs">Never used</span>
                        </div>
                    @endif
                </div>

                <!-- Package Footer -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                    <div class="flex justify-between items-center">
                        <div class="text-xs text-gray-500">
                            ID: #{{ $package->id }}
                        </div>
                        <button wire:click="viewAccountDetails({{ $package->id }})" 
                            class="text-red-600 hover:text-red-700 text-sm font-medium transition-colors duration-200 flex items-center space-x-1">
                            <span>View Details</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-16">
                    <div class="bg-gray-50 rounded-full p-6 w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No packages found</h3>
                    <p class="text-gray-500 mb-6">
                        @if($searchTerm || $statusFilter !== 'all')
                            No packages match your current filters. Try adjusting your search criteria.
                        @else
                            Get started by purchasing your first credit report package.
                        @endif
                    </p>
                    @if(!$searchTerm && $statusFilter === 'all')
                        <div class="space-x-4">
                            <a href="{{ route('payment.plan') }}" 
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Buy Your First Package
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($packages->hasPages())
        <div class="flex justify-center mt-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-2">
                {{ $packages->links() }}
            </div>
        </div>
    @endif

    <!-- Auto-refresh Script -->
    <script>
        setInterval(function() {
            @this.call('refreshData');
        }, {{ $refreshInterval }});
    </script>
</div>

<style>
    /* Custom scrollbar for better UX */
    .overflow-auto::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    
    .overflow-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .overflow-auto::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    .overflow-auto::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }

    /* Smooth hover transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }

    /* Custom pagination styling */
    nav[role="navigation"] {
        @apply flex items-center justify-between;
    }
    
    nav[role="navigation"] span,
    nav[role="navigation"] a {
        @apply px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-red-50 hover:text-red-700 transition-colors duration-200 rounded;
    }
    
    nav[role="navigation"] span[aria-current="page"] {
        @apply bg-red-500 text-white border-red-500;
    }
    
    nav[role="navigation"] a:hover {
        @apply bg-red-50 border-red-300 text-red-700;
    }
    
    nav[role="navigation"] .disabled {
        @apply opacity-50 cursor-not-allowed;
    }
</style>

</div>