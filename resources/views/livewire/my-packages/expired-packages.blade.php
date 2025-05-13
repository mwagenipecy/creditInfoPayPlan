<div>
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-3xl font-bold text-gray-900">Expired Packages</h1>
            <div class="flex items-center space-x-4">
                <div class="text-sm text-gray-500">
                    Last updated: {{ now()->format('H:i') }}
                </div>
                <button wire:click="$refresh" 
                    class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors duration-200">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Expired</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $this->totalExpired }}</p>
                    </div>
                    <div class="bg-red-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Unused Credits</p>
                        <p class="text-3xl font-bold text-orange-600">{{ number_format($this->totalWastedCredits) }}</p>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4C12.962 2.833 11.038 2.833 10.268 4L3.34 16.0001c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Amount Spent</p>
                        <p class="text-3xl font-bold text-gray-900">TZS {{ number_format($this->totalAmountSpent) }}</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm">Avg. Utilization</p>
                        <p class="text-3xl font-bold">
                            {{ $this->totalExpired > 0 ? number_format((($this->totalExpired * 1000 - $this->totalWastedCredits) / max($this->totalExpired * 1000, 1)) * 100, 1) : 0 }}%
                        </p>
                    </div>
                    <div class="bg-red-400 bg-opacity-30 p-3 rounded-full">
                        <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"/>
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
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input wire:model.debounce.300ms="searchTerm" 
                    type="text" 
                    placeholder="Search expired packages..." 
                    class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg bg-white shadow-sm text-gray-900 placeholder-gray-500 focus:ring-red-500 focus:border-red-500">
            </div>

            <div class="flex items-center space-x-4">
                <select wire:model="perPage" class="border border-gray-200 bg-white rounded-lg px-3 py-2 text-gray-700 focus:ring-red-500 focus:border-red-500">
                    <option value="9">9 per page</option>
                    <option value="18">18 per page</option>
                    <option value="27">27 per page</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Loading State -->
    <div wire:loading.delay.short class="flex justify-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-red-500 border-t-transparent"></div>
    </div>

    <!-- Expired Packages Grid -->
    <div wire:loading.remove.delay class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($this->expiredPackages as $package)
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <!-- Package Header -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $package->package_type ?: 'Standard Package' }}</h3>
                            <p class="text-sm text-gray-600">{{ $package->account_number }}</p>
                        </div>
                        <div class="flex items-center">
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                Expired
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Package Content -->
                <div class="p-6 space-y-4">
                    <!-- Usage Progress -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Final Usage</span>
                            <span class="text-sm text-gray-600">
                                {{ $package->total_reports - $package->remaining_reports }}/{{ $package->total_reports }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-gradient-to-r from-red-500 to-red-600 h-2.5 rounded-full transition-all duration-500" 
                                style="width: {{ $this->getUsagePercentage($package) }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>{{ $this->getUsagePercentage($package) }}% utilized</span>
                            @if($package->remaining_reports > 0)
                                <span class="text-orange-600">{{ $package->remaining_reports }} unused</span>
                            @endif
                        </div>
                    </div>

                    <!-- Expiration Info -->
                    <div class="flex items-center space-x-2">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-600">Expired</p>
                            <p class="text-lg font-semibold text-red-600">
                                {{ $this->getDaysExpiredAgo($package) }} days ago
                            </p>
                        </div>
                    </div>

                    <!-- Package Duration -->
                    <div class="border-t border-gray-100 pt-4">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Active Period</p>
                                <p class="font-medium text-gray-900">{{ $package->valid_from->format('M d') }} - {{ $package->valid_until->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Total Days</p>
                                <p class="font-medium text-gray-900">{{ $package->valid_from->diffInDays($package->valid_until) }} days</p>
                            </div>
                        </div>
                    </div>

                    <!-- Last Activity -->
                    @if($package->last_used)
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Last used {{ $package->last_used->diffForHumans() }}
                        </div>
                    @endif
                </div>

                <!-- Package Footer -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                    <div class="flex justify-between items-center">
                        <div class="text-xs text-gray-500">
                            Amount: TZS {{ number_format($package->amount_paid) }}
                        </div>
                        <button wire:click="toggleUsageDetails({{ $package->id }})" 
                            class="text-red-600 hover:text-red-700 text-sm font-medium transition-colors duration-200 flex items-center">
                            @if(isset($showUsageDetails[$package->id]))
                                <span class="mr-1">Hide Details</span>
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            @else
                                <span class="mr-1">View Details</span>
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            @endif
                        </button>
                    </div>
                    
                    <!-- Usage Details -->
                    @if(isset($showUsageDetails[$package->id]))
                        <div class="mt-4 pt-4 border-t border-gray-200 usage-details-enter">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Usage History</h4>
                            @if($package->usageLogs->count() > 0)
                                <div class="space-y-2 max-h-32 overflow-y-auto">
                                    @foreach($package->usageLogs as $log)
                                        <div class="flex justify-between text-xs">
                                            <span class="text-gray-600">{{ $log->used_at->format('M d, Y H:i') }}</span>
                                            <span class="text-gray-900">{{ $log->reports_used }} report{{ $log->reports_used > 1 ? 's' : '' }}</span>
                                        </div>
                                    @endforeach
                                    @if($package->usageLogs->count() == 5)
                                        <div class="text-xs text-gray-500 italic">
                                            (Showing last 5 entries)
                                        </div>
                                    @endif
                                </div>
                            @else
                                <p class="text-xs text-gray-500">No usage recorded</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No expired packages</h3>
                    <p class="mt-1 text-sm text-gray-500">All your packages are still active or you haven't purchased any yet.</p>
                    <div class="mt-6">
                        <a href="{{ route('payment.plan') }}" 
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Buy Package
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($this->expiredPackages->hasPages())
        <div class="mt-8">
            {{ $this->expiredPackages->links() }}
        </div>
    @endif
</div>

<style>
    /* Custom scrollbar for usage history */
    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 2px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #dc2626;
        border-radius: 2px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #b91c1c;
    }

    /* Animation for usage details */
    .usage-details-enter {
        animation: slideDown 0.2s ease-out;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Custom pagination styling to match red theme */
    .pagination {
        @apply flex items-center justify-center space-x-1;
    }
    
    .pagination .page-link {
        @apply px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-red-50 hover:text-red-700 transition-colors duration-200;
    }
    
    .pagination .page-item.active .page-link {
        @apply bg-red-500 text-white border-red-500;
    }
    
    .pagination .page-link:hover {
        @apply bg-red-50 border-red-300 text-red-700;
    }
</style>
</div>