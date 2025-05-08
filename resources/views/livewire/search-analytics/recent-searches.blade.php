<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Recent Searches</h2>
    
    <div class="flex flex-col sm:flex-row justify-between space-y-4 sm:space-y-0 sm:space-x-4 mb-6">
        <!-- Date Range Filter -->
        <div>
            <select wire:model.live="dateRange" class="bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="today">Today</option>
                <option value="yesterday">Yesterday</option>
                <option value="last_7_days">Last 7 Days</option>
                <option value="last_30_days">Last 30 Days</option>
                <option value="current_month">Current Month</option>
            </select>
        </div>
        
        <!-- Search Type Filter -->
        <div>
            <select wire:model.live="searchType" class="bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="all">All Types</option>
                @foreach($searchTypes as $type)
                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Search Term Filter -->
        <div class="flex-grow max-w-md">
            <div class="relative">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="searchTerm" 
                    placeholder="Filter by search term..." 
                    class="bg-white border border-gray-300 text-gray-700 py-2 px-4 pl-10 rounded-md text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Per Page Selector -->
        <div>
            <select wire:model.live="perPage" class="bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>
        </div>
    </div>
    
    <!-- Search Results Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th scope="col" class="text-sm font-medium text-gray-700 px-4 py-2 text-left cursor-pointer" wire:click="sortBy('user_id')">
                        User
                        @if($sortField === 'user_id')
                            <span>{!! $sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                        @endif
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-700 px-4 py-2 text-left cursor-pointer" wire:click="sortBy('search_term')">
                        Search Term
                        @if($sortField === 'search_term')
                            <span>{!! $sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                        @endif
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-700 px-4 py-2 text-left cursor-pointer" wire:click="sortBy('search_type')">
                        Type
                        @if($sortField === 'search_type')
                            <span>{!! $sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                        @endif
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-700 px-4 py-2 text-left cursor-pointer" wire:click="sortBy('search_category')">
                        Category
                        @if($sortField === 'search_category')
                            <span>{!! $sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                        @endif
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-700 px-4 py-2 text-right cursor-pointer" wire:click="sortBy('cost')">
                        Cost
                        @if($sortField === 'cost')
                            <span>{!! $sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                        @endif
                    </th>
                    <th scope="col" class="text-sm font-medium text-gray-700 px-4 py-2 text-left cursor-pointer" wire:click="sortBy('created_at')">
                    Date
                        @if($sortField === 'created_at')
                            <span>{!! $sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($searches as $search)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="text-sm text-gray-900 px-4 py-2 whitespace-nowrap">
                            {{ $search->user ? "{$search->user->first_name} {$search->user->last_name}" : 'Unknown' }}
                        </td>
                        <td class="text-sm text-gray-900 px-4 py-2 whitespace-nowrap">{{ $search->search_term }}</td>
                        <td class="text-sm text-gray-900 px-4 py-2 whitespace-nowrap">{{ ucfirst($search->search_type) }}</td>
                        <td class="text-sm text-gray-900 px-4 py-2 whitespace-nowrap">{{ ucfirst($search->search_category) }}</td>
                        <td class="text-sm text-gray-900 px-4 py-2 whitespace-nowrap text-right">${{ number_format($search->cost, 4) }}</td>
                        <td class="text-sm text-gray-900 px-4 py-2 whitespace-nowrap">{{ $search->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                @endforeach
                
                @if(count($searches) === 0)
                    <tr>
                        <td colspan="6" class="text-sm text-gray-500 px-4 py-4 text-center italic">No searches found matching your criteria.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="mt-4">
        {{ $searches->links() }}
    </div>
</div>