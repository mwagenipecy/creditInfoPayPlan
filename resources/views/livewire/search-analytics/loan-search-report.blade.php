<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Loan Search Analytics</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Loan Searches Card -->
        <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
            <h3 class="text-sm font-medium text-blue-800 mb-2">Total Loan Searches</h3>
            <p class="text-2xl font-bold text-blue-900">{{ number_format($totalLoanSearches) }}</p>
        </div>
        
        <!-- Average Loan Amount Card -->
        <div class="bg-green-50 rounded-lg p-4 border border-green-100">
            <h3 class="text-sm font-medium text-green-800 mb-2">Average Loan Amount</h3>
            <p class="text-2xl font-bold text-green-900">${{ number_format($averageLoanAmount, 2) }}</p>
        </div>
        
        <!-- Median Loan Amount Card -->
        <div class="bg-purple-50 rounded-lg p-4 border border-purple-100">
            <h3 class="text-sm font-medium text-purple-800 mb-2">Median Loan Amount</h3>
            <p class="text-2xl font-bold text-purple-900">${{ number_format($medianLoanAmount, 2) }}</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Loan Amount Distribution -->
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Loan Amount Distribution</h3>
            
            @if(count($loanAmountDistribution) > 0)
                <div class="space-y-3">
                    @foreach($loanAmountDistribution as $bucket)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span>{{ $bucket['range'] }}</span>
                                <span>{{ $bucket['count'] }} ({{ $bucket['percentage'] }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $bucket['percentage'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">No data available for the selected period.</p>
            @endif
        </div>
        
        <!-- Top Loan Search Terms -->
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Top Loan Search Terms</h3>
            
            @if(count($topLoanSearchTerms) > 0)
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th scope="col" class="text-sm font-medium text-gray-700 px-4 py-2 text-left">Search Term</th>
                                <th scope="col" class="text-sm font-medium text-gray-700 px-4 py-2 text-right">Count</th>
                                <th scope="col" class="text-sm font-medium text-gray-700 px-4 py-2 text-right">Avg. Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topLoanSearchTerms as $term)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="text-sm text-gray-900 px-4 py-2 whitespace-nowrap text-left">{{ $term['search_term'] }}</td>
                                    <td class="text-sm text-gray-900 px-4 py-2 whitespace-nowrap text-right">{{ $term['count'] }}</td>
                                    <td class="text-sm text-gray-900 px-4 py-2 whitespace-nowrap text-right">${{ number_format($term['avg_amount'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 italic">No data available for the selected period.</p>
            @endif
        </div>
    </div>
    
    <!-- Recent Loan Searches Table -->
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <h3 class="text-lg font-medium text-gray-700 mb-4">Recent Loan Searches</h3>
        
        @if(count($loanSearches) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th scope="col" class="text-sm font-medium text-gray-700 px-4 py-2 text-left">User</th>
                            <th scope="col" class="text-sm font-medium text-gray-700 px-4 py-2 text-left">Search Term</th>
                            <th scope="col" class="text-sm font-medium text-gray-700 px-4 py-2 text-right">Loan Amount</th>
                            <th scope="col" class="text-sm font-medium text-gray-700 px-4 py-2 text-right">Cost</th>
                            <th scope="col" class="text-sm font-medium text-gray-700 px-4 py-2 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loanSearches as $search)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="text-sm text-gray-900 px-4 py-2 whitespace-nowrap">
                                    {{ $search->user ? "{$search->user->first_name} {$search->user->last_name}" : 'Unknown' }}
                                </td>
                                <td class="text-sm text-gray-900 px-4 py-2 whitespace-nowrap">{{ $search->search_term }}</td>
                                <td class="text-sm text-gray-900 px-4 py-2 whitespace-nowrap text-right">${{ number_format($search->loan_amount, 2) }}</td>
                                <td class="text-sm text-gray-900 px-4 py-2 whitespace-nowrap text-right">${{ number_format($search->cost, 4) }}</td>
                                <td class="text-sm text-gray-900 px-4 py-2 whitespace-nowrap">{{ $search->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $loanSearches->links() }}
            </div>
        @else
            <p class="text-gray-500 italic">No loan searches found for the selected period.</p>
        @endif
    </div>
</div>