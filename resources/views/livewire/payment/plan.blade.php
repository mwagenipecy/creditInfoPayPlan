<div>
    {{-- Be like water. --}}

    <div class="max-w-6xl mx-auto px-4 pt-8 pb-4">
    <div class="flex justify-center">
        <div class="bg-white rounded-full shadow-md px-1 py-1 inline-flex">
            <button class="px-6 py-2 rounded-full bg-[#C40F12] text-white font-medium text-sm">Monthly</button>
            <button class="px-6 py-2 rounded-full text-gray-700 font-medium text-sm hover:bg-gray-100 transition">Annual (Save 15%)</button>
        </div>
    </div>
</div>

<!-- Pay-As-You-Go Option -->
<div class="max-w-6xl mx-auto px-4 mb-12">
    <div class="flex justify-center">
        <div class="inline-block rounded-full border border-gray-200 px-6 py-3 bg-white shadow-sm">
            <div class="text-center">
                <span class="block text-sm text-gray-500 mb-1">Pay-As-You-Go Option</span>
                <span class="font-bold text-xl text-gray-800">TZS 2,500</span> <span class="text-sm text-gray-500">per statement</span>
            </div>
        </div>
    </div>
</div>

<!-- Standard Pricing Tiers -->
<div id="pricing-plans" class="max-w-6xl mx-auto px-4 mb-20">
    <h2 class="text-3xl font-bold text-center mb-12">Choose Your Statement Processing Plan</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Tier 1 -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all hover:shadow-lg group relative">
            <div class="absolute inset-x-0 top-0 h-1 bg-gray-200"></div>
            <div class="p-8">
                <div class="text-sm text-gray-500 uppercase tracking-wider font-medium mb-2">Tier 1</div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">TZS 125,000<span class="text-base font-normal text-gray-500">/month</span></h3>
                <p class="text-gray-600 pb-6 border-b border-gray-100 mb-6">Perfect for small microfinance institutions</p>
                
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-500">Statements included</span>
                        <span class="text-lg font-bold text-gray-900">50</span>
                    </div>
                    
                    <div class="w-full bg-gray-100 rounded-full h-2 mb-6">
                        <div class="bg-gray-400 h-2 rounded-full" style="width: 20%"></div>
                    </div>
                    
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-500">Price per statement</span>
                        <span class="font-semibold text-gray-900">TZS 2,500</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Savings</span>
                        <span class="font-semibold text-gray-500">0%</span>
                    </div>
                </div>
                
                <a  wire:click="openModal( 'Tier 1', 125000)"  href="#" class="block w-full text-center px-6 py-3 rounded-lg border-2 border-[#C40F12] text-[#C40F12] font-semibold hover:bg-[#C40F12] hover:text-white transition group-hover:shadow-md">
                    Select Plan
                    
                </a>
            </div>






            
            <div class="bg-gray-50 px-8 py-6">
                <p class="text-sm font-medium text-gray-700 mb-4">Plan includes:</p>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Basic statement processing</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Standard templates</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Email support</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Tier 2 - Popular -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-lg overflow-hidden transition-all hover:shadow-xl group relative transform md:scale-105 z-10">
            <div class="absolute inset-x-0 top-0 h-1 bg-[#C40F12]"></div>
            <div class="absolute top-0 right-0">
                <div class="bg-[#C40F12] text-white text-xs font-bold px-6 py-1 rounded-bl-lg">
                    POPULAR CHOICE
                </div>
            </div>
            <div class="p-8">
                <div class="text-sm text-[#C40F12] uppercase tracking-wider font-medium mb-2">Tier 2</div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">TZS 300,000<span class="text-base font-normal text-gray-500">/month</span></h3>
                <p class="text-gray-600 pb-6 border-b border-gray-100 mb-6">Ideal for growing microfinance institutions</p>
                
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-500">Statements included</span>
                        <span class="text-lg font-bold text-gray-900">135</span>
                    </div>
                    
                    <div class="w-full bg-gray-100 rounded-full h-2 mb-6">
                        <div class="bg-[#C40F12] h-2 rounded-full" style="width: 50%"></div>
                    </div>
                    
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-500">Price per statement</span>
                        <span class="font-semibold text-gray-900">TZS 2,222</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Savings</span>
                        <span class="font-semibold text-green-600">11%</span>
                    </div>
                </div>
                
                <a href="#" wire:click="openModal( 'Tier 2', 300000)"  class="block w-full text-center px-6 py-3 rounded-lg border-2 bg-[#C40F12] text-white font-semibold hover:bg-[#A00D10] border-[#C40F12] transition shadow-sm group-hover:shadow-md">
                    Select Plan
                </a>
            </div>
            
            <div class="bg-gray-50 px-8 py-6">
                <p class="text-sm font-medium text-gray-700 mb-4">Plan includes:</p>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Enhanced statement processing</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Custom templates</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Priority email & chat support</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Basic data analytics</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Tier 3 -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all hover:shadow-lg group relative">
            <div class="absolute inset-x-0 top-0 h-1 bg-gray-800"></div>
            <div class="p-8">
                <div class="text-sm text-gray-500 uppercase tracking-wider font-medium mb-2">Tier 3</div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">TZS 1,000,000<span class="text-base font-normal text-gray-500">/month</span></h3>
                <p class="text-gray-600 pb-6 border-b border-gray-100 mb-6">Comprehensive solution for microfinance banks & FinTechs</p>
                
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-500">Statements included</span>
                        <span class="text-lg font-bold text-gray-900">500</span>
                    </div>
                    
                    <div class="w-full bg-gray-100 rounded-full h-2 mb-6">
                        <div class="bg-gray-800 h-2 rounded-full" style="width: 80%"></div>
                    </div>
                    
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-500">Price per statement</span>
                        <span class="font-semibold text-gray-900">TZS 2,000</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Savings</span>
                        <span class="font-semibold text-green-600">20%</span>
                    </div>
                </div>
                
                <a href="#" wire:click="openModal( 'Tier 3', 1000000)" class="block w-full text-center px-6 py-3 rounded-lg border-2 border-gray-800 text-gray-800 font-semibold hover:bg-gray-800 hover:text-white transition group-hover:shadow-md">
                    Select Plan
                </a>
            </div>
            
            <div class="bg-gray-50 px-8 py-6">
                <p class="text-sm font-medium text-gray-700 mb-4">Plan includes:</p>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Premium statement processing</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Custom branded templates</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>24/7 dedicated support</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>Advanced analytics dashboard</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span>API integration</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Advanced Tiers -->
<div class="bg-gray-50 py-16">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1 bg-gray-200 rounded-full text-sm font-medium text-gray-800 mb-4">ENTERPRISE SOLUTIONS</span>
            <h2 class="text-3xl font-bold text-gray-900">Advanced Processing Packages</h2>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Tailored solutions for financial institutions with high-volume statement processing requirements and large customer bases.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Tier 4 -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all hover:shadow-lg flex flex-col">
                <div class="p-8 flex-grow">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <div class="text-sm text-gray-500 uppercase tracking-wider font-medium mb-2">Tier 4</div>
                            <h3 class="text-3xl font-bold text-gray-900">TZS 2,500,000<span class="text-base font-normal text-gray-500">/month</span></h3>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-full">
                            <i class="fas fa-building text-gray-700 text-xl"></i>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-100 pt-6 mb-6">
                        <div class="flex justify-between mb-4">
                            <span class="text-gray-600">Statements</span>
                            <span class="font-bold text-gray-900">1,500 statements</span>
                        </div>
                        <div class="flex justify-between mb-4">
                            <span class="text-gray-600">Price per Statement</span>
                            <span class="font-bold text-gray-900">TZS 1,667</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Savings vs Pay-As-You-Go</span>
                            <span class="font-bold text-green-600">33% savings</span>
                        </div>
                    </div>
                    
                    <p class="text-gray-600 mb-8">
                        Ideal for microfinance banks, FinTechs & commercial banks with significant processing needs.
                    </p>
                    
                    <a href="#" class="block w-full text-center px-6 py-3 rounded-lg border-2 border-gray-800 text-gray-800 font-semibold hover:bg-gray-800 hover:text-white transition">
                        Contact Sales
                    </a>
                </div>
                
                <div class="bg-gray-50 px-8 py-6">
                    <p class="font-medium text-gray-700 mb-3">Enterprise features:</p>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2">
                        <li class="flex items-center text-sm">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Advanced data analytics</span>
                        </li>
                        <li class="flex items-center text-sm">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Dedicated account manager</span>
                        </li>
                        <li class="flex items-center text-sm">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Full API integration</span>
                        </li>
                        <li class="flex items-center text-sm">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>SSO implementation</span>
                        </li>
                        <li class="flex items-center text-sm">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Custom reporting</span>
                        </li>
                        <li class="flex items-center text-sm">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Quarterly reviews</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Tier 5 -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all hover:shadow-lg flex flex-col">
                <div class="p-8 flex-grow">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <div class="text-sm text-gray-500 uppercase tracking-wider font-medium mb-2">Tier 5</div>
                            <h3 class="text-3xl font-bold text-gray-900">TZS 10,000,000<span class="text-base font-normal text-gray-500">/month</span></h3>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-full">
                            <i class="fas fa-globe text-gray-700 text-xl"></i>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-100 pt-6 mb-6">
                        <div class="flex justify-between mb-4">
                            <span class="text-gray-600">Statements</span>
                            <span class="font-bold text-gray-900">10,000 statements</span>
                        </div>
                        <div class="flex justify-between mb-4">
                            <span class="text-gray-600">Price per Statement</span>
                            <span class="font-bold text-gray-900">TZS 1,000</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Savings vs Pay-As-You-Go</span>
                            <span class="font-bold text-green-600">43% savings</span>
                        </div>
                    </div>
                    
                    <p class="text-gray-600 mb-8">
                        Ultimate solution for microfinance banks & commercial banks with high transaction volumes.
                    </p>
                    
                    <a href="#" class="block w-full text-center px-6 py-3 rounded-lg border-2 border-gray-800 text-gray-800 font-semibold hover:bg-gray-800 hover:text-white transition">
                        Contact Sales
                    </a>
                </div>
                
                <div class="bg-gray-50 px-8 py-6">
                    <p class="font-medium text-gray-700 mb-3">Comprehensive features:</p>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2">
                        <li class="flex items-center text-sm">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Everything in Tier 4</span>
                        </li>
                        <li class="flex items-center text-sm">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Multi-branch support</span>
                        </li>
                        <li class="flex items-center text-sm">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Advanced fraud detection</span>
                        </li>
                        <li class="flex items-center text-sm">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Staff training</span>
                        </li>
                        <li class="flex items-center text-sm">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Priority processing</span>
                        </li>
                        <li class="flex items-center text-sm">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Executive insights dashboard</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>







@if($showModal)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white w-full max-w-3xl rounded-xl shadow-2xl relative overflow-hidden">
            <!-- Loading Spinner Overlay -->
            <div wire:loading.delay.long class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center z-10">
                <div class="relative h-12 w-12">
                    <div class="absolute animate-ping h-full w-full rounded-full bg-red-400 opacity-75"></div>
                    <div class="relative flex items-center justify-center h-full w-full rounded-full bg-red-500">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <div class="bg-gray-50 p-6 border-b border-gray-100">
                <div class="flex items-center">
                    <img src="{{ asset('/image/selcom.png') }}" alt="Selcom" class="h-8 w-auto mr-3">
                    <h2 class="text-2xl font-bold text-gray-800">Complete Payment</h2>
                </div>
                <p class="text-gray-500 mt-1">Secure payment processing via Selcom</p>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-5">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <span class="text-xs font-medium uppercase tracking-wider text-gray-500">Selected Plan</span>
                            <div class="text-lg font-semibold text-gray-800 mt-1">{{ $planName }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Number of Statements</label>
                            <div class="relative">
                                <input type="number" wire:model.live="statementCount" min="1"
                                    class="w-full pl-4 pr-12 py-3 rounded-lg border-gray-200 focus:ring-red-500 focus:border-red-500 shadow-sm">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-400">qty</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Total Amount</label>
                            <div class="relative">
                                <input type="text" wire:model="amount" readonly
                                    class="w-full pl-12 py-3 rounded-lg bg-gray-50 border-gray-200 text-gray-800 font-medium shadow-sm">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500 font-medium">TZS</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mobile Network</label>
                            <div class="relative">
                                <select wire:model="network"
                                    class="w-full pl-4 pr-10 py-3 rounded-lg appearance-none border-gray-200 focus:ring-red-500 focus:border-red-500 shadow-sm">
                                    <option value="">-- Choose network --</option>
                                    <option value="vodacom">Vodacom</option>
                                    <option value="tigo">Tigo</option>
                                    <option value="airtel">Airtel</option>
                                    <option value="halotel">Halotel</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('network') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" wire:model="phone" placeholder="07XXXXXXXX"
                                class="w-full pl-4 py-3 rounded-lg border-gray-200 focus:ring-red-500 focus:border-red-500 shadow-sm">
                            @error('phone') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-2">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" wire:model="acceptTerms" class="mt-1 rounded text-red-500 border-gray-300 focus:ring-red-500">
                                <span class="ml-2 text-sm text-gray-600 leading-5">
                                    I accept the <a href="#" class="text-red-500 font-medium hover:underline">terms & conditions</a>.
                                </span>
                            </label>
                            @error('acceptTerms') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 p-6 border-t border-gray-100 flex flex-col sm:flex-row-reverse sm:justify-between sm:items-center gap-4">
                <button wire:click="submitPayment"
                    class="w-full sm:w-auto px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition shadow-sm flex justify-center items-center">
                    <span>Confirm & Pay</span>
                    <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
                <button wire:click="$set('showModal', false)" 
                    class="w-full sm:w-auto px-6 py-3 bg-white text-gray-600 font-medium rounded-lg border border-gray-200 hover:bg-gray-50 transition flex justify-center items-center">
                    <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Cancel</span>
                </button>
            </div>
        </div>
    </div>
@endif



</div>
