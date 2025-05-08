<!-- resources/views/livewire/credit-report-search.blade.php -->
<div>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-red-600 text-white flex items-center justify-between">
            <h2 class="font-bold text-xl">Credit Report Search</h2>
            <div class="text-sm bg-red-500 px-3 py-1 rounded-full">
                Reports retrieved: {{ $reportCount }}
            </div>
        </div>
        
        <div class="p-6">
            @if($errorMessage)
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
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
                        <input type="text" id="fullName" wire:model.defer="fullName" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" placeholder="e.g. ELICK S JUMA">
                        @error('fullName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="idNumber" class="block text-sm font-medium text-gray-700 mb-1">ID Number</label>
                        <input type="text" id="idNumber" wire:model.defer="idNumber" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" placeholder="e.g. 19910425-47316-00003-25">
                    </div>
                    
                    <div>
                        <label for="idNumberType" class="block text-sm font-medium text-gray-700 mb-1">ID Number Type</label>
                        <select id="idNumberType" wire:model.defer="idNumberType" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                            <option value="NationalID">National ID</option>
                            <option value="PassportNumber">Passport Number</option>
                            <option value="TaxNumber">Tax Number</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="phoneNumber" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="text" id="phoneNumber" wire:model.defer="phoneNumber" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" placeholder="Optional phone number">
                    </div>
                </div>
                
                <div class="mt-6">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="search">Search</span>
                        <span wire:loading wire:target="search" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
    

    @if(count($searchResults) > 0)
    <div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
        <div class="px-6 py-4 bg-gradient-to-r from-red-600 to-red-500 text-white flex justify-between items-center">
            <h2 class="font-semibold text-xl">Search Results ({{ count($searchResults) }} found)</h2>
            <div class="text-sm bg-white bg-opacity-20 px-3 py-1 rounded-full">
                Select a person to view their credit report
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">Full Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Birth</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">National ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($searchResults as $index => $result)
                        <tr class="{{ $selectedId == $result['CreditinfoId'] ? 'bg-red-50' : ($index % 2 == 0 ? 'bg-white' : 'bg-gray-50') }} hover:bg-gray-100 transition-colors duration-150">
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
                                        {{ $result['Address'] }}
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">Address not provided</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <button wire:click="getReport('{{ $result['CreditinfoId'] }}')" 
                                        class="{{ $selectedId == $result['CreditinfoId'] ? 'bg-red-500 text-white' : 'bg-white text-red-600 border border-red-600' }} 
                                        hover:bg-red-500 hover:text-white transition-colors duration-200 px-4 py-2 rounded-md flex items-center justify-center space-x-1 w-full max-w-[140px] mx-auto
                                        {{ $isLoadingReport && $selectedId == $result['CreditinfoId'] ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                        {{ $isLoadingReport ? 'disabled' : '' }}>
                                    <span wire:loading.remove wire:target="getReport('{{ $result['CreditinfoId'] }}')">
                                        <svg class="h-4 w-4 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span>Get Report</span>
                                    </span>
                                    <span wire:loading wire:target="getReport('{{ $result['CreditinfoId'] }}')">
                                        <svg class="animate-spin h-4 w-4 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span>Loading...</span>
                                    </span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="bg-gray-50 px-6 py-3 text-xs text-gray-500 border-t border-gray-200">
            Showing {{ count($searchResults) }} result(s)
        </div>
    </div>
@endif

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
            </div>
        </div>
    </div>
@endif

@if($reportUrl)
    <div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
        <div class="px-6 py-4 bg-gradient-to-r from-red-600 to-red-500 text-white flex justify-between items-center">
            <h2 class="font-semibold text-xl">Credit Report</h2>
            <div class="text-sm">
                <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full">ID: {{ $selectedId }}</span>
            </div>
        </div>
        
        <div class="p-8">
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md mb-8">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Report Ready</h3>
                        <p class="mt-1 text-sm text-green-700">Your credit report has been successfully retrieved and is ready to download.</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200">
                        <div class="text-sm font-medium text-gray-500 mb-1">Document Type</div>
                        <div class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Credit Report (PDF)
                        </div>
                    </div>
                    
                    <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200">
                        <div class="text-sm font-medium text-gray-500 mb-1">Generated At</div>
                        <div class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ now()->format('d M Y, H:i') }}
                        </div>
                    </div>
                    
                    <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200">
                        <div class="text-sm font-medium text-gray-500 mb-1">Status</div>
                        <div class="text-lg font-semibold text-green-600 flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Ready for Download
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col items-center">
                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-3 bg-white text-sm text-gray-500">Report Actions</span>
                    </div>
                </div>


              

                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ $reportUrl }}" target="_blank" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                        <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download PDF Report
                    </a>


                    
                    <a href="{{ $reportUrl }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                        <svg class="-ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        View Report
                    </a>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-50 px-6 py-4 text-sm text-gray-600 border-t border-gray-200 flex items-center justify-between">
            <div>
                <span class="font-medium">Note:</span> This report is for authorized use only.
            </div>
            <div>
                <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded">Download Count: {{ $reportCount ?? '1' }}</span>
            </div>
        </div>
    </div>
@endif



</div>