<div>
    {{-- Header Section --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-black text-white flex items-center justify-between">
            <h2 class="font-bold text-xl">Credit Report Search</h2>
            <div class="flex items-center space-x-3">
                <div class="text-sm bg-red-600 px-3 py-1 rounded-full">
                    Reports retrieved: {{ $reportCount }}
                </div>
                @if(isset($remainingReports) && $remainingReports > 0)
                    <div class="text-sm bg-green-600 px-3 py-1 rounded-full">
                        Credits remaining: {{ $remainingReports }}
                    </div>
                @endif
            </div>
        </div>
        
        {{-- Search Form --}}
        <div class="p-6">
            @if($errorMessage)
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ $errorMessage }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            <form wire:submit.prevent="search">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="fullName" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" 
                               id="fullName" 
                               wire:model.defer="fullName" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                               placeholder="e.g. ELICK S JUMA">
                        @error('fullName') 
                            <span class="text-red-500 text-xs">{{ $message }}</span> 
                        @enderror
                    </div>
                    
                    <div>
                        <label for="idNumber" class="block text-sm font-medium text-gray-700 mb-1">ID Number</label>
                        <input type="text" 
                               id="idNumber" 
                               wire:model.defer="idNumber" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                               placeholder="e.g. 19910425-47316-00003-25">
                    </div>
                    
                    <div>
                        <label for="idNumberType" class="block text-sm font-medium text-gray-700 mb-1">ID Number Type</label>
                        <select id="idNumberType" 
                                wire:model.defer="idNumberType" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                            <option value="NationalID">National ID</option>
                            <option value="PassportNumber">Passport Number</option>
                            <option value="TaxNumber">Tax Number</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="phoneNumber" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="text" 
                               id="phoneNumber" 
                               wire:model.defer="phoneNumber" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                               placeholder="Optional phone number">
                    </div>
                </div>
                
                <div class="mt-6">
                    <button type="submit" 
                            wire:loading.attr="disabled"
                            wire:target="search"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                        <span wire:loading.remove wire:target="search" class="flex items-center">
                            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Search
                        </span>
                        <span wire:loading wire:target="search" class="flex items-center">
                            <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Searching...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Too Many Results Warning --}}
    @if(count($searchResults ?? []) > 50 && !$selectedId)
        <div class="mt-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Too Many Results</h3>
                    <p class="mt-1 text-sm text-red-700">
                        Found {{ count($searchResults) }} results. Please refine your search criteria for better accuracy.
                        Use specific ID numbers or complete names to get more precise results.
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Processing Banner --}}
    @if($selectedId && $isLoadingReport)
        <div class="mt-8 bg-black border-l-4 border-red-500 p-4 rounded-md shadow" id="processing-banner">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="animate-spin h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-white">Processing Credit Report</h3>
                    <p class="mt-1 text-sm text-gray-300">
                        Generating report for selected person (ID: {{ $selectedId }}). Please wait...
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Search Results Table --}}
    @if(count($searchResults ?? []) > 0 && !$selectedId && !$reportUrl)
        <div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200" id="search-results">
            <div class="px-6 py-4 bg-black text-white flex justify-between items-center">
                <h2 class="font-semibold text-xl">Search Results ({{ count($searchResults) }} found)</h2>
                <div class="flex items-center space-x-4">
                    <div class="text-sm bg-red-600 px-3 py-1 rounded-full">
                        Page {{ $currentPage ?? 1 }} of {{ ceil(count($searchResults) / ($perPage ?? 10)) }}
                    </div>
                    @if(count($searchResults) <= 10)
                        <div class="text-sm bg-gray-600 px-3 py-1 rounded-full">
                            Select a person to view their credit report
                        </div>
                    @endif
                </div>
            </div>

            {{-- Results per page selector --}}
            @if(count($searchResults) > 10)
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <label class="text-sm font-medium text-gray-700">Results per page:</label>
                        <select wire:model="perPage" 
                                wire:loading.attr="disabled"
                                wire:target="perPage"
                                class="text-sm border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-red-500 focus:border-red-500 disabled:opacity-50">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    
                    @if(count($searchResults) > 25)
                        <div class="text-sm text-gray-600 flex items-center">
                            <svg class="h-4 w-4 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Consider using ID number for exact match
                        </div>
                    @endif
                </div>
            @endif
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Birth</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">National ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $perPage = $perPage ?? 10;
                            $currentPage = $currentPage ?? 1;
                            $offset = ($currentPage - 1) * $perPage;
                            $paginatedResults = array_slice($searchResults, $offset, $perPage);
                        @endphp
                        
                        @foreach($paginatedResults as $index => $result)
                            <tr class="{{ ($offset + $index) % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-red-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                                            <span class="text-red-600 font-medium">{{ substr($result['FullName'] ?? 'N/A', 0, 1) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">{{ $result['FullName'] ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-500">ID: {{ $result['CreditinfoId'] ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(isset($result['DateOfBirth']) && !is_array($result['DateOfBirth']))
                                        <div class="text-sm text-gray-900">{{\Carbon\Carbon::parse($result['DateOfBirth'])->format('d M Y')}}</div>
                                        <div class="text-xs text-gray-500">{{\Carbon\Carbon::parse($result['DateOfBirth'])->age}} years old</div>
                                    @else
                                        <span class="text-sm text-gray-500">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(isset($result['NationalID']) && !is_array($result['NationalID']))
                                        <div class="text-sm font-medium text-gray-900 font-mono">{{ $result['NationalID'] }}</div>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Not Available</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if(isset($result['Address']) && !is_array($result['Address']) && $result['Address'] !== '')
                                        <div class="flex items-center">
                                            <svg class="h-4 w-4 text-gray-400 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ Str::limit($result['Address'], 30) }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">Address not provided</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <button wire:click="getReport('{{ $result['CreditinfoId'] }}')" 
                                            wire:loading.attr="disabled"
                                            wire:target="getReport('{{ $result['CreditinfoId'] }}')"
                                            class="bg-red-600 text-white hover:bg-red-700 transition-all duration-200 px-4 py-2 rounded-md flex items-center justify-center space-x-1 w-full max-w-[140px] mx-auto disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span wire:loading.remove wire:target="getReport('{{ $result['CreditinfoId'] }}')">
                                            <svg class="h-4 w-4 inline mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Get Report
                                        </span>
                                        <span wire:loading wire:target="getReport('{{ $result['CreditinfoId'] }}')" class="flex items-center">
                                            <svg class="animate-spin h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Loading...
                                        </span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination Controls --}}
            @if(count($searchResults) > 10)
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Showing {{ $offset + 1 }} to {{ min($offset + $perPage, count($searchResults)) }} of {{ count($searchResults) }} results
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            {{-- Previous Button --}}
                            <button wire:click="previousPage" 
                                    wire:loading.attr="disabled"
                                    wire:target="previousPage"
                                    @if($currentPage <= 1) disabled @endif
                                    class="px-3 py-1 text-sm bg-white border border-gray-300 rounded {{ $currentPage <= 1 ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-50' }} disabled:opacity-50 transition-all duration-200">
                                <span wire:loading.remove wire:target="previousPage">Previous</span>
                                <span wire:loading wire:target="previousPage" class="flex items-center">
                                    <svg class="animate-spin h-3 w-3 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Loading
                                </span>
                            </button>
                            
                            {{-- Page Numbers --}}
                            @php
                                $totalPages = ceil(count($searchResults) / $perPage);
                                $startPage = max(1, $currentPage - 2);
                                $endPage = min($totalPages, $startPage + 4);
                                $startPage = max(1, $endPage - 4);
                            @endphp
                            
                            @for($page = $startPage; $page <= $endPage; $page++)
                                <button wire:click="goToPage({{ $page }})" 
                                        wire:loading.attr="disabled"
                                        wire:target="goToPage({{ $page }})"
                                        class="px-3 py-1 text-sm border rounded transition-all duration-200 {{ $page == $currentPage ? 'bg-red-600 text-white border-red-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-red-50 hover:border-red-300' }} disabled:opacity-50">
                                    <span wire:loading.remove wire:target="goToPage({{ $page }})">{{ $page }}</span>
                                    <span wire:loading wire:target="goToPage({{ $page }})" class="flex items-center">
                                        <svg class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </span>
                                </button>
                            @endfor
                            
                            {{-- Next Button --}}
                            <button wire:click="nextPage" 
                                    wire:loading.attr="disabled"
                                    wire:target="nextPage"
                                    @if($currentPage >= $totalPages) disabled @endif
                                    class="px-3 py-1 text-sm bg-white border border-gray-300 rounded {{ $currentPage >= $totalPages ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-50' }} disabled:opacity-50 transition-all duration-200">
                                <span wire:loading.remove wire:target="nextPage">Next</span>
                                <span wire:loading wire:target="nextPage" class="flex items-center">
                                    <svg class="animate-spin h-3 w-3 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Loading
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-gray-50 px-6 py-3 text-xs text-gray-500 border-t border-gray-200">
                    Showing {{ count($searchResults) }} result(s)
                </div>
            @endif
        </div>
    @endif

    {{-- Report Error Section --}}
    @if($reportError)
        <div class="mt-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Error Retrieving Report</h3>
                    <p class="mt-1 text-sm text-red-700">{{ $reportError }}</p>
                    <p class="mt-2 text-xs text-red-700">Please try again or contact support if the issue persists.</p>
                    <button wire:click="clearSelection" 
                            wire:loading.attr="disabled"
                            wire:target="clearSelection"
                            class="mt-3 inline-flex items-center px-3 py-2 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50 transition-all duration-200">
                        <span wire:loading.remove wire:target="clearSelection">Try Another Selection</span>
                        <span wire:loading wire:target="clearSelection" class="flex items-center">
                            <svg class="animate-spin h-3 w-3 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Loading...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Credit Report Ready Section --}}
    @if($reportUrl)
        <div class="mt-8 bg-white shadow-xl rounded-lg overflow-hidden border border-gray-200" id="report-section">
            <div class="px-6 py-4 bg-black text-white flex justify-between items-center">
                <div class="flex items-center">
                    <svg class="h-6 w-6 mr-3 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <h2 class="font-semibold text-xl">Credit Report Ready</h2>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="text-sm bg-red-600 px-3 py-1 rounded-full">
                        ID: {{ $selectedId }}
                    </div>
                    <div class="text-sm bg-green-600 px-3 py-1 rounded-full">
                        Ready for Download
                    </div>
                </div>
            </div>
            
            <div class="p-8">
                {{-- Selected User Information --}}
                @php
                    $selectedUser = collect($searchResults ?? [])->firstWhere('CreditinfoId', $selectedId);
                @endphp
                
                @if($selectedUser)
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Report Generated For</h3>
                        <div class="flex items-center bg-white p-4 rounded-md shadow-sm border border-gray-200">
                            <div class="flex-shrink-0 h-16 w-16 bg-red-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-medium text-xl">{{ substr($selectedUser['FullName'] ?? 'N/A', 0, 1) }}</span>
                            </div>
                            <div class="ml-6 flex-1">
                                <div class="text-xl font-semibold text-gray-900">{{ $selectedUser['FullName'] ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500 mt-1">Creditinfo ID: {{ $selectedUser['CreditinfoId'] ?? 'N/A' }}</div>
                                <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                    @if(isset($selectedUser['DateOfBirth']) && !is_array($selectedUser['DateOfBirth']))
                                        <div>
                                            <span class="font-medium text-gray-700">Date of Birth:</span><br>
                                            <span class="text-gray-600">{{\Carbon\Carbon::parse($selectedUser['DateOfBirth'])->format('d M Y')}}</span>
                                            <span class="text-gray-500">({{\Carbon\Carbon::parse($selectedUser['DateOfBirth'])->age}} years old)</span>
                                        </div>
                                    @endif
                                    @if(isset($selectedUser['NationalID']) && !is_array($selectedUser['NationalID']))
                                        <div>
                                            <span class="font-medium text-gray-700">National ID:</span><br>
                                            <span class="font-mono text-gray-600">{{ $selectedUser['NationalID'] }}</span>
                                        </div>
                                    @endif
                                    @if(isset($selectedUser['Address']) && !is_array($selectedUser['Address']) && $selectedUser['Address'] !== '')
                                        <div>
                                            <span class="font-medium text-gray-700">Address:</span><br>
                                            <span class="text-gray-600">{{ $selectedUser['Address'] }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Report Information --}}
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Report Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm font-medium text-gray-500 mb-1">Status</div>
                            <div class="text-lg font-semibold text-green-600 flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Ready for Download
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm font-medium text-gray-500 mb-1">Generated</div>
                            <div class="text-lg font-semibold text-gray-900">
                                {{ now()->format('M d, Y') }}
                            </div>
                            <div class="text-xs text-gray-500">{{ now()->format('h:i A') }}</div>
                        </div>
                        <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200">
                            <div class="text-sm font-medium text-gray-500 mb-1">Format</div>
                            <div class="text-lg font-semibold text-red-600 flex items-center">
                                <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                PDF Document
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Action Buttons --}}
                <div class="flex flex-col items-center">
                    <div class="relative mb-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="px-4 bg-white text-sm font-medium text-gray-500">Download Options</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        <a href="{{ $reportUrl }}" 
                           target="_blank" 
                           class="inline-flex items-center justify-center px-8 py-4 border border-transparent rounded-lg shadow-lg text-lg font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:scale-105 hover:shadow-xl">
                            <svg class="-ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download PDF Report
                        </a>

                        <a href="{{ $reportUrl }}" 
                           target="_blank"
                           class="inline-flex items-center justify-center px-8 py-4 border-2 border-black rounded-lg shadow-lg text-lg font-medium text-black bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-all duration-200 hover:shadow-xl">
                            <svg class="-ml-1 mr-3 h-6 w-6 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View in Browser
                        </a>
                    </div>

                    {{-- Navigation Options --}}
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button wire:click="clearSelection" 
                                wire:loading.attr="disabled"
                                wire:target="clearSelection"
                                class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="clearSelection" class="flex items-center">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Search New Person
                            </span>
                            <span wire:loading wire:target="clearSelection" class="flex items-center">
                                <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Loading...
                            </span>
                        </button>

                        @if(count($searchResults ?? []) > 1)
                            <button wire:click="clearSelection" 
                                    wire:loading.attr="disabled"
                                    wire:target="clearSelection"
                                    class="inline-flex items-center justify-center px-6 py-3 border border-green-400 rounded-md shadow-sm text-base font-medium text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span wire:loading.remove wire:target="clearSelection" class="flex items-center">
                                    <svg class="-ml-1 mr-2 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Select Different Person ({{ count($searchResults) - 1 }} more available)
                                </span>
                                <span wire:loading wire:target="clearSelection" class="flex items-center">
                                    <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Loading...
                                </span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            
            {{-- Footer --}}
            <div class="bg-gray-100 px-6 py-4 text-sm text-gray-600 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="font-medium">Important:</span> This report contains confidential information and is for authorized use only.
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="bg-black text-white text-xs font-medium px-3 py-1 rounded-full">Company Reports: {{ $reportCount ?? '0' }}</span>
                        @if(isset($remainingReports))
                            <span class="bg-green-600 text-white text-xs font-medium px-3 py-1 rounded-full">Credits: {{ $remainingReports }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- JavaScript for Enhanced Functionality --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-scroll to report section when it becomes available
            const checkForReportSection = () => {
                const reportSection = document.getElementById('report-section');
                if (reportSection) {
                    setTimeout(() => {
                        reportSection.scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'start'
                        });
                        
                        // Add subtle highlight effect with red theme
                        reportSection.style.transform = 'scale(1.01)';
                        reportSection.style.transition = 'transform 0.3s ease-in-out';
                        reportSection.style.boxShadow = '0 0 20px rgba(220, 38, 38, 0.3)';
                        
                        setTimeout(() => {
                            reportSection.style.transform = 'scale(1)';
                            reportSection.style.boxShadow = '';
                        }, 300);
                    }, 200);
                }
            };

            // Enhanced button click feedback with red theme
            const addButtonFeedback = () => {
                const buttons = document.querySelectorAll('button[wire\\:click]');
                buttons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Add loading state feedback
                        this.style.transform = 'scale(0.95)';
                        this.style.transition = 'transform 0.1s ease-in-out';
                        this.style.boxShadow = '0 0 10px rgba(220, 38, 38, 0.5)';
                        
                        setTimeout(() => {
                            this.style.transform = 'scale(1)';
                            this.style.boxShadow = '';
                        }, 100);
                    });
                });
            };

            // Initialize button feedback
            addButtonFeedback();

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Escape key to clear selection
                if (e.key === 'Escape') {
                    const clearButton = document.querySelector('[wire\\:click="clearSelection"]');
                    if (clearButton && !clearButton.disabled) {
                        clearButton.click();
                    }
                }
                
                // Ctrl/Cmd + D to download report
                if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
                    e.preventDefault();
                    const downloadLink = document.querySelector('a[href*="{{ $reportUrl ?? '' }}"]');
                    if (downloadLink) {
                        downloadLink.click();
                    }
                }
            });

            // Listen for Livewire updates
            if (typeof Livewire !== 'undefined') {
                Livewire.hook('message.processed', (message, component) => {
                    // Re-add button feedback after Livewire updates
                    addButtonFeedback();
                    
                    // Check if report URL was set and loading finished
                    if (component.get('reportUrl') && !component.get('isLoadingReport')) {
                        checkForReportSection();
                    }
                });
            }

            // Auto-hide processing banner when report is ready
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList') {
                        const reportSection = document.getElementById('report-section');
                        const processingBanner = document.getElementById('processing-banner');
                        
                        if (reportSection && processingBanner) {
                            processingBanner.style.opacity = '0';
                            processingBanner.style.transition = 'opacity 0.5s ease-out';
                            setTimeout(() => {
                                if (processingBanner.style.opacity === '0') {
                                    processingBanner.style.display = 'none';
                                }
                            }, 500);
                        }
                    }
                });
            });

            // Observe the document body for changes
            observer.observe(document.body, { childList: true, subtree: true });

            // Add custom styles
            const style = document.createElement('style');
            style.textContent = `
                .pulse-red {
                    animation: pulse-red 2s infinite;
                }
                
                @keyframes pulse-red {
                    0%, 100% { 
                        box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7); 
                    }
                    70% { 
                        box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); 
                    }
                }
                
                [wire\\:loading] {
                    position: relative;
                }
                
                [wire\\:loading]::after {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: rgba(0, 0, 0, 0.05);
                    border-radius: inherit;
                    pointer-events: none;
                }

                .hover-scale:hover {
                    transform: scale(1.02);
                }

                .button-loading {
                    pointer-events: none;
                    opacity: 0.7;
                }
            `;
            document.head.appendChild(style);
        });
    </script>

    {{-- Styles --}}
    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .animate-spin {
            animation: spin 1s linear infinite;
        }
        
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .duration-200 {
            transition-duration: 200ms;
        }
        
        .transform {
            transform: translateX(0) translateY(0) rotate(0) skewX(0) skewY(0) scaleX(1) scaleY(1);
        }
        
        .hover\:scale-105:hover {
            transform: scale(1.05);
        }
        
        .hover\:shadow-xl:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</div>