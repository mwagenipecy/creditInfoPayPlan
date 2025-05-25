<div>
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Company Usage Analytics</h1>
                    <p class="text-gray-600 mt-1">Comprehensive analysis of your company's credit report usage and package performance</p>
                </div>
                <button wire:click="refreshData" 
                    class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors duration-200 flex items-center space-x-1">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>Refresh</span>
                </button>
            </div>
            
            @if(!$hasRealData)
                <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-1.167-2.694-1.167-3.464 0L3.34 16c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <p class="text-amber-700 text-sm">
                            <strong>No Usage Data:</strong> No report generation activity found for the selected period.
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Enhanced Summary Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Reports Generated -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Reports Generated</p>
                        <p class="text-3xl font-bold">{{ number_format($usageSummary['total_reports_generated']) }}</p>
                        <p class="text-red-200 text-xs mt-1">In {{ $selectedYear }}</p>
                    </div>
                    <div class="bg-red-400 bg-opacity-30 p-3 rounded-full">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Unique Credit Reports -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Unique Credit Reports</p>
                        <p class="text-3xl font-bold text-blue-600">{{ number_format($usageSummary['total_unique_reports']) }}</p>
                        <p class="text-gray-400 text-xs mt-1">Distinct individuals</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Package Utilization Rate -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Utilization Rate</p>
                        <p class="text-3xl font-bold {{ $usageSummary['utilization_rate'] >= 80 ? 'text-green-600' : ($usageSummary['utilization_rate'] >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $usageSummary['utilization_rate'] }}%
                        </p>
                        <p class="text-gray-400 text-xs mt-1">Of purchased reports</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Days -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Active Days</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($usageSummary['unique_days']) }}</p>
                        <p class="text-gray-400 text-xs mt-1">Avg: {{ $usageSummary['average_per_day'] }}/day</p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-full">
                        <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Statistics Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Reports Remaining -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Reports Remaining</p>
                        <p class="text-2xl font-bold">{{ number_format($usageSummary['total_reports_remaining']) }}</p>
                        <p class="text-orange-200 text-xs mt-1">From {{ number_format($usageSummary['total_reports_purchased']) }} purchased</p>
                    </div>
                    <div class="bg-orange-400 bg-opacity-30 p-3 rounded-full">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Accounts -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Active Packages</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($usageSummary['active_accounts']) }}</p>
                        <p class="text-gray-400 text-xs mt-1">Currently available</p>
                    </div>
                    <div class="bg-indigo-50 p-3 rounded-full">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Investment -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Investment</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($usageSummary['total_investment']) }}</p>
                        <p class="text-gray-400 text-xs mt-1">TZS spent on packages</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-full">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peak Usage and Most Active Account Info -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            @if($usageSummary['peak_day'])
                <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 p-6 rounded-xl shadow-lg border border-yellow-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Peak Usage Day</h3>
                            <p class="text-yellow-700 text-lg font-medium">
                                {{ Carbon\Carbon::parse($usageSummary['peak_day']->date)->format('F d, Y') }}
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ number_format($usageSummary['peak_day']->daily_total) }} reports generated on this day
                            </p>
                        </div>
                        <div class="bg-yellow-200 p-3 rounded-full">
                            <svg class="h-8 w-8 text-yellow-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            @endif

            @if($usageSummary['most_active_account'])
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-6 rounded-xl shadow-lg border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Most Active Package</h3>
                            <p class="text-blue-700 text-lg font-medium">
                                {{ $usageSummary['most_active_account']->account_number }}
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ $usageSummary['most_active_account']->package_type ?: 'Standard Package' }} • 
                                {{ number_format($usageSummary['most_active_account']->total_used) }} reports generated
                            </p>
                        </div>
                        <div class="bg-blue-200 p-3 rounded-full">
                            <svg class="h-8 w-8 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Filters Section -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 mb-8">
            <div class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-40">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                    <select wire:model.live="selectedYear" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-red-500 focus:border-red-500">
                        @for($year = date('Y'); $year >= 2020; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>

                <div class="flex-1 min-w-40">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                    <select wire:model.live="selectedMonth" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">All Months</option>
                        @for($month = 1; $month <= 12; $month++)
                            <option value="{{ $month }}">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                        @endfor
                    </select>
                </div>

                <div class="flex-1 min-w-40">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Package</label>
                    <select wire:model.live="selectedAccount" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">All Packages</option>
                        @foreach($availableAccounts as $account)
                            <option value="{{ $account->id }}">
                                {{ $account->account_number }} - {{ $account->package_type ?: 'Standard' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex space-x-2">
                    <button wire:click="setDateRange('month')" 
                        class="px-4 py-2 text-sm rounded-lg transition-colors duration-200 {{ $dateRange === 'month' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Monthly
                    </button>
                    <button wire:click="setDateRange('quarter')" 
                        class="px-4 py-2 text-sm rounded-lg transition-colors duration-200 {{ $dateRange === 'quarter' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Quarterly
                    </button>
                    <button wire:click="setDateRange('year')" 
                        class="px-4 py-2 text-sm rounded-lg transition-colors duration-200 {{ $dateRange === 'year' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Yearly
                    </button>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Usage Trend Chart -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Usage Trend</h3>
                    <div class="flex space-x-2">
                        <button wire:click="setChartType('line')" 
                            class="p-2 rounded-lg transition-colors duration-200 {{ $chartType === 'line' ? 'bg-red-100 text-red-600' : 'text-gray-400 hover:text-gray-600' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </button>
                        <button wire:click="setChartType('bar')" 
                            class="p-2 rounded-lg transition-colors duration-200 {{ $chartType === 'bar' ? 'bg-red-100 text-red-600' : 'text-gray-400 hover:text-gray-600' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="h-80 flex items-center justify-center" wire:ignore>
                    <canvas id="usageChart" style="width: 100%; height: 100%;"></canvas>
                </div>
            </div>

            <!-- Hourly Pattern Chart -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Hourly Usage Pattern</h3>
                <div class="h-80 flex items-center justify-center" wire:ignore>
                    <canvas id="hourlyChart" style="width: 100%; height: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Detailed Usage Logs -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Detailed Usage Log</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Company-wide report generation activity for {{ $selectedYear }}
                            {{ $selectedMonth ? ' - ' . date('F', mktime(0, 0, 0, $selectedMonth, 1)) : '' }}
                            {{ $selectedAccount ? ' - Selected Package Only' : '' }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <select wire:model.live="perPage" class="border border-gray-200 bg-white rounded-lg px-3 py-2 text-sm focus:ring-red-500 focus:border-red-500">
                            <option value="20">20 per page</option>
                            <option value="50">50 per page</option>
                            <option value="100">100 per page</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="p-6">
                @if($usageLogs->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium text-gray-900">Date & Time</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-900">Package</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-900">Reports Used</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-900">Remaining After</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-900">Metadata</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($usageLogs as $log)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-4 py-3">
                                            <div class="text-gray-900 font-medium">{{ $log->used_at->format('M d, Y') }}</div>
                                            <div class="text-gray-500 text-xs">{{ $log->used_at->format('H:i:s') }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-gray-900 font-medium">{{ $log->account->account_number }}</div>
                                            <div class="text-gray-500 text-xs">{{ $log->account->package_type ?: 'Standard Package' }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                {{ $log->reports_used }} report{{ $log->reports_used > 1 ? 's' : '' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-gray-900 font-medium">
                                                {{ number_format($log->remaining_reports) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($log->metadata)
                                                @php
                                                    $metadata = is_string($log->metadata) ? json_decode($log->metadata, true) : $log->metadata;
                                                @endphp
                                                @if(isset($metadata['creditinfo_id']))
                                                    <div class="text-xs text-gray-600">
                                                        <span class="font-medium">Credit ID:</span> {{ $metadata['creditinfo_id'] }}
                                                    </div>
                                                @endif
                                                @if(isset($metadata['user_id']))
                                                    <div class="text-xs text-gray-500">
                                                        User ID: {{ $metadata['user_id'] }}
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-gray-400 text-xs">No metadata</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($usageLogs->hasPages())
                        <div class="mt-6 flex justify-center">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-2">
                                {{ $usageLogs->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <div class="bg-gray-50 rounded-full p-6 w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No usage data found</h3>
                        <p class="text-gray-500 mb-6">
                            @if($selectedMonth || $selectedAccount)
                                No reports have been generated for the selected filters.
                            @else
                                No reports have been generated in {{ $selectedYear }}.
                            @endif
                        </p>
                        @if($selectedMonth || $selectedAccount)
                            <button wire:click="$set('selectedMonth', ''); $set('selectedAccount', '')" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-colors duration-200">
                                Clear Filters
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Chart.js Integration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:init', function() {
            let usageChart = null;
            let hourlyChart = null;

            function initializeCharts() {
                const usageChartElement = document.getElementById('usageChart');
                const hourlyChartElement = document.getElementById('hourlyChart');

                if (!usageChartElement || !hourlyChartElement) {
                    setTimeout(initializeCharts, 100);
                    return;
                }

                try {
                    // Destroy existing charts
                    if (usageChart) {
                        usageChart.destroy();
                        usageChart = null;
                    }
                    if (hourlyChart) {
                        hourlyChart.destroy();
                        hourlyChart = null;
                    }
                    
                    // Get real data from Livewire component
                    const chartData = @this.get('chartData');
                    const hourlyData = @this.get('hourlyPattern');
                    const chartType = @this.get('chartType');
                    const dateRange = @this.get('dateRange');
                    
                    // Usage Trend Chart
                    const usageCtx = usageChartElement.getContext('2d');
                    
                    const labels = chartData.map(item => item.period_name);
                    const data = chartData.map(item => parseInt(item.total_reports || 0));
                    
                    usageChart = new Chart(usageCtx, {
                        type: chartType,
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Reports Generated',
                                data: data,
                                backgroundColor: chartType === 'line' ? 'rgba(220, 38, 38, 0.1)' : 'rgba(220, 38, 38, 0.8)',
                                borderColor: 'rgb(220, 38, 38)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: chartType === 'line',
                                borderRadius: chartType === 'bar' ? 4 : 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    text: `${dateRange.charAt(0).toUpperCase() + dateRange.slice(1)} Report Generation Trend`
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Reports Generated'
                                    },
                                    ticks: {
                                        stepSize: 1,
                                        callback: function(value) {
                                            return Number.isInteger(value) ? value : '';
                                        }
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: dateRange.charAt(0).toUpperCase() + dateRange.slice(1)
                                    }
                                }
                            }
                        }
                    });
                    
                    // Hourly Pattern Chart
                    const hourlyCtx = hourlyChartElement.getContext('2d');
                    
                    const hourlyLabels = Array.from({length: 24}, (_, i) => `${String(i).padStart(2, '0')}:00`);
                    const hourlyValues = Array.from({length: 24}, (_, i) => {
                        const found = hourlyData.find(item => parseInt(item.hour) === i);
                        return found ? parseInt(found.total_reports) : 0;
                    });
                    
                    hourlyChart = new Chart(hourlyCtx, {
                        type: 'bar',
                        data: {
                            labels: hourlyLabels,
                            datasets: [{
                                label: 'Reports Generated',
                                data: hourlyValues,
                                backgroundColor: hourlyValues.map(value => 
                                    value > 0 ? 'rgba(220, 38, 38, 0.8)' : 'rgba(220, 38, 38, 0.2)'
                                ),
                                borderColor: 'rgb(220, 38, 38)',
                                borderRadius: 4,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    text: 'Hourly Activity Pattern'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Reports Generated'
                                    },
                                    ticks: {
                                        stepSize: 1,
                                        callback: function(value) {
                                            return Number.isInteger(value) ? value : '';
                                        }
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Hour of Day'
                                    }
                                }
                            }
                        }
                    });
                    
                    console.log('Charts initialized with real company data:', {
                        usageData: data,
                        hourlyData: hourlyValues,
                        totalReports: data.reduce((a, b) => a + b, 0)
                    });
                    
                } catch (error) {
                    console.error('Error initializing charts:', error);
                }
            }

            // Initialize charts
            setTimeout(initializeCharts, 500);
            
            // Listen for updates
            Livewire.on('chartUpdated', () => {
                setTimeout(initializeCharts, 200);
            });

            document.addEventListener('livewire:updated', function() {
                setTimeout(initializeCharts, 200);
            });
        });
    </script>

    <style>
        /* Custom pagination styling */
        nav[role="navigation"] span,
        nav[role="navigation"] a {
            @apply px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-red-50 hover:text-red-700 transition-colors duration-200 rounded;
        }
        
        nav[role="navigation"] span[aria-current="page"] {
            @apply bg-red-500 text-white border-red-500;
        }
    </style>

</div>