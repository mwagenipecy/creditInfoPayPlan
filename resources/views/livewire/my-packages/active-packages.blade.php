<div>
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-3xl font-bold text-gray-900">Active Packages</h1>
            <div class="flex items-center space-x-4">
                <div class="text-sm text-gray-500">
                    Auto-refresh: {{ $refreshInterval / 1000 }}s
                </div>
                <button wire:click="refreshData" 
                    class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors duration-200">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm">Total Reports Remaining</p>
                        <p class="text-3xl font-bold">{{ number_format($this->totalRemainingReports) }}</p>
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
                        <p class="text-gray-500 text-sm">Active Packages</p>
                        <p class="text-3xl font-bold text-gray-900">{{22 }}</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Expiring Soon</p>
                        <p class="text-3xl font-bold text-gray-900">


                    </p>
                    </div>
                    <div class="bg-yellow-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4C12.962 2.833 11.038 2.833 10.268 4L3.34 16.0001c-.77.833.192 2.5 1.732 2.5z"/>
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
                    placeholder="Search packages..." 
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

    <!-- Packages Grid -->
    <div wire:loading.remove.delay class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($packages as $package)
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <!-- Package Header -->
                <div class="bg-gradient-to-r from-red-50 to-red-100 p-6 border-b border-red-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $package->package_type ?: 'Standard Package' }}</h3>
                            <p class="text-sm text-gray-600">{{ $package->account_number }}</p>
                        </div>
                        <div class="flex items-center">
                            @if($package->daysRemaining() <= 7)
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    Expiring Soon
                                </span>
                            @else
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    Active
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
                            <span class="text-sm font-medium text-gray-700">Reports Used</span>
                            <span class="text-sm text-gray-600">
                                {{ $package->total_reports - $package->remaining_reports }}/{{ $package->total_reports }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-red-500 h-2.5 rounded-full transition-all duration-500" 
                                style="width: {{ $this->getUsagePercentage($package) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $package->remaining_reports }} reports remaining</p>
                    </div>

                    <!-- Time Remaining -->
                    <div class="flex items-center space-x-2">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-600">Expires in</p>
                            <p class="text-lg font-semibold {{ $this->getDaysRemainingClass($package->daysRemaining()) }}">
                                {{ $package->daysRemaining() }} days
                            </p>
                        </div>
                    </div>

                    <!-- Purchase Details -->
                    <div class="border-t border-gray-100 pt-4">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Purchased</p>
                                <p class="font-medium text-gray-900">{{ $package->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Amount</p>
                                <p class="font-medium text-gray-900">TZS {{ number_format($package->amount_paid) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Last Used -->
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
                            Expires {{ $package->valid_until->format('M d, Y') }}
                        </div>
                        <button wire:click="$dispatch('viewDetails', {{ $package->id }})" 
                            class="text-red-600 hover:text-red-700 text-sm font-medium transition-colors duration-200">
                            View Details →
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No active packages</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by purchasing a report package.</p>
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
   

    <!-- Auto-refresh Script -->
    <script>
        setInterval(function() {
            @this.dispatch('refreshed');
        }, {{ $refreshInterval }});
    </script>
</div>

<style>
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
