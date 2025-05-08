<div class="py-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Search Analytics Dashboard</h1>
            <p class="mt-2 text-sm text-gray-600">Monitor your search activity, costs, and insights</p>
        </div>
        
        <!-- Filters Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div class="flex flex-wrap gap-3 items-center">
                    <!-- Date Range Filter -->
                    <div>
                        <select wire:model.live="dateRange" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="current_month">Current Month</option>
                            <option value="last_month">Last Month</option>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="last_7_days">Last 7 Days</option>
                            <option value="last_30_days">Last 30 Days</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                    
                    <!-- Custom Date Range (only shows when Custom Range is selected) -->
                    @if($dateRange === 'custom')
                    <div class="flex items-center space-x-2">
                        <div>
                            <label for="customStartDate" class="sr-only">Start Date</label>
                            <input type="date" id="customStartDate" wire:model="customStartDate" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <span class="text-gray-500">to</span>
                        <div>
                            <label for="customEndDate" class="sr-only">End Date</label>
                            <input type="date" id="customEndDate" wire:model="customEndDate" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <button type="button" wire:click="applyCustomDateRange" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Apply
                        </button>
                    </div>
                    @endif
                    
                    <!-- Search Type Filter -->
                    <div>
                        <select wire:model.live="searchType" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="all">All Search Types</option>
                            @foreach($searchTypes as $type)
                            <option value="{{ $type }}">{{ ucfirst(str_replace('_', ' ', $type)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- User Filter -->
                    <div>
                        <select wire:model.live="userId" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Export Button -->
                <button type="button" wire:click="exportData" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Report
                </button>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Searches Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Searches</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($totalSearches) }}</p>
                    </div>
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 text-blue-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 flex items-center text-sm">
                    <span class="{{ $searchTrend >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                        {{ $searchTrend >= 0 ? '+' : '' }}{{ number_format($searchTrend, 1) }}%
                    </span>
                    <span class="text-gray-500 ml-1">vs previous period</span>
                </div>
            </div>
            
            <!-- Total Cost Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Cost</p>
                        <p class="text-3xl font-bold text-gray-900">${{ number_format($totalCost, 2) }}</p>
                    </div>
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-100 text-green-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 flex items-center text-sm">
                    <span class="text-gray-500">Avg. {{ number_format($averageSearchesPerDay, 1) }} searches per day</span>
                </div>
            </div>
            
            <!-- Loan Searches Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Loan Searches</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($loanSearchCount) }}</p>
                    </div>
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-amber-100 text-amber-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 flex items-center text-sm">
                    <span class="text-gray-500">{{ number_format($loanSearchPercentage, 1) }}% of total searches</span>
                </div>
            </div>
            
            <!-- Average Loan Amount Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Avg. Loan Amount</p>
                        <p class="text-3xl font-bold text-gray-900">${{ number_format($averageLoanAmount, 2) }}</p>
                    </div>
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 text-purple-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 flex items-center text-sm">
                    <span class="text-gray-500">Most searched term: {{ $mostSearchedTerm }}</span>
                </div>
            </div>
        </div>
        
        <!-- Monthly Usage Chart -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Monthly Search Usage</h2>
            @livewire('search-analytics.monthly-usage-chart', [
                'dateRange' => $dateRange, 
                'searchType' => $searchType, 
                'userId' => $userId,
                'customStartDate' => $customStartDate,
                'customEndDate' => $customEndDate
            ])
        </div>
        
        <!-- Two-Column Layout for Bottom Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Searches (2 columns) -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Recent Searches</h2>
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                </div>
                
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Search Term</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cost</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentSearches as $search)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-xs font-medium text-gray-600">
                                                {{ $search->user ? substr($search->user->first_name, 0, 1) . substr($search->user->last_name, 0, 1) : 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $search->user ? $search->user->first_name . ' ' . $search->user->last_name : 'Unknown' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $search->search_term }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($search->search_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $search->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($search->cost, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No recent searches found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Loan Search Report (1 column) -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Loan Search Analysis</h2>
                @livewire('search-analytics.loan-search-report', [
                    'dateRange' => $dateRange, 
                    'userId' => $userId,
                    'customStartDate' => $customStartDate,
                    'customEndDate' => $customEndDate
                ])
            </div>
        </div>
    </div>
</div>