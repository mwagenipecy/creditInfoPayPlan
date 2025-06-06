<div>
    {{-- Be like water. --}}

    <div class="max-w-6xl mx-auto px-4 pt-8 pb-16">
    <!-- Header -->
    <div class="text-center mb-16">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Choose Your Plan
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Select the credit reporting package that best fits your business needs
        </p>
    </div>

    <!-- Plans Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-5xl mx-auto">
        
        <!-- Package 1 - Basic Package -->
        <div class="bg-white rounded-2xl shadow-lg border-2 border-blue-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
            <!-- Basic Badge -->
            <div class="absolute top-0 right-0 bg-blue-600 text-white text-xs font-semibold px-4 py-2 rounded-bl-lg">
                BASIC PLAN
            </div>
            
            <!-- Header -->
            <div class="p-8 pb-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-user text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Basic Package</h3>
                        <p class="text-blue-600 text-sm font-medium">Credit Report  </p>
                    </div>
                </div>
                
                <div class="mb-6">
                    <div class="flex items-baseline">
                        <span class="text-3xl font-bold text-gray-900">TZS 2,500</span>
                        <span class="text-gray-600 ml-2">/report</span>
                    </div>
                    <div class="mt-2 space-y-1">
                        <p class="text-sm text-gray-600 font-medium">VAT Inclusive</p>
                        <p class="text-sm text-blue-600 font-medium">Minimum: TZS 125,000</p>
                        <p class="text-sm text-orange-600 font-medium">Valid for 1 Month</p>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="px-8 pb-8">
                <h4 class="font-semibold text-gray-900 mb-4">What's included:</h4>
                <ul class="space-y-3">
                    <li class="flex items-center text-sm">
                        <i class="fas fa-check text-green-500 mr-3 flex-shrink-0"></i>
                        <span>Creditinfo Report Plus</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <i class="fas fa-check text-green-500 mr-3 flex-shrink-0"></i>
                        <span>Basic Training Program</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <i class="fas fa-check text-green-500 mr-3 flex-shrink-0"></i>
                        <span>Data Submission Support</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <i class="fas fa-check text-green-500 mr-3 flex-shrink-0"></i>
                        <span>Basic Dispute Support</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <i class="fas fa-check text-green-500 mr-3 flex-shrink-0"></i>
                        <span>Monthly Validity Period</span>
                    </li>
                </ul>
                
                <!-- Usage Info -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-blue-700">Minimum Balance</span>
                        <span class="text-sm font-bold text-blue-900">TZS 125,000</span>
                    </div>
                    <div class="mt-2 w-full bg-blue-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                    <p class="text-xs text-blue-600 mt-2">Pay TZS 2,500 per report with minimum balance requirement</p>
                </div>
                
                <button wire:click="openModal('Basic Package', 125000)" 
                        class="w-full mt-8 bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200">
                    Choose Basic Package
                </button>
            </div>
        </div>

        <!-- Package 2 - Premium Package -->
        <div class="bg-white rounded-2xl shadow-lg border-2 border-red-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
            <!-- Popular Badge -->
            <div class="absolute top-0 right-0 bg-red-600 text-white text-xs font-semibold px-4 py-2 rounded-bl-lg">
                RECOMMENDED
            </div>
            
            <!-- Header -->
            <div class="p-8 pb-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-star text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Premium Package</h3>
                        <p class="text-red-600 text-sm font-medium"> Credit Report </p>
                    </div>
                </div>
                
                <div class="mb-6">
                    <div class="flex items-baseline">
                        <span class="text-3xl font-bold text-gray-900">TZS 285,000</span>
                    </div>
                    <div class="mt-2 space-y-1">
                        <p class="text-sm text-gray-600 font-medium">VAT Inclusive</p>
                        <p class="text-sm text-blue-600 font-medium">Maximum: 200 reports/month</p>
                        <p class="text-sm text-orange-600 font-medium">Valid for 1 Month</p>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="px-8 pb-8">
                <h4 class="font-semibold text-gray-900 mb-4">What's included:</h4>
                <ul class="space-y-3">
                    <li class="flex items-center text-sm">
                        <i class="fas fa-check text-green-500 mr-3 flex-shrink-0"></i>
                        <span>Creditinfo Report Plus</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <i class="fas fa-check text-green-500 mr-3 flex-shrink-0"></i>
                        <span>Comprehensive Scoring Report</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <i class="fas fa-check text-green-500 mr-3 flex-shrink-0"></i>
                        <span>Negative Credit Report</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <i class="fas fa-check text-green-500 mr-3 flex-shrink-0"></i>
                        <span>Skip Tracing Services (Quarterly)</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <i class="fas fa-check text-green-500 mr-3 flex-shrink-0"></i>
                        <span>Training & Refresh Sessions</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <i class="fas fa-check text-green-500 mr-3 flex-shrink-0"></i>
                        <span>TRA Verification Reports</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <i class="fas fa-check text-green-500 mr-3 flex-shrink-0"></i>
                        <span>Data Submission Support</span>
                    </li>
                    <li class="flex items-center text-sm">
                        <i class="fas fa-check text-green-500 mr-3 flex-shrink-0"></i>
                        <span>Dispute Management Platform</span>
                    </li>
                </ul>
                
                <!-- Usage Info -->
                <div class="mt-6 p-4 bg-red-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-red-700">Report Capacity</span>
                        <span class="text-sm font-bold text-red-900">200 reports/month</span>
                    </div>
                    <div class="mt-2 w-full bg-red-200 rounded-full h-2">
                        <div class="bg-red-600 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                    <p class="text-xs text-red-600 mt-2">Complete solution for comprehensive credit analysis</p>
                </div>
                
                <button wire:click="openModal('Premium Package', 285000)" 
                        class="w-full mt-8 bg-red-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-red-700 transition-colors duration-200">
                    Choose Premium Package
                </button>
            </div>
        </div>
    </div>

  
</div>



@if($showModal)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white w-full max-w-3xl rounded-xl shadow-2xl relative overflow-hidden">
            
            @if($paymentStatus === 'processing')
                <!-- Enhanced Processing State -->
                <div class="absolute inset-0 bg-gradient-to-br from-red-50 to-red-100 flex flex-col items-center justify-center z-10 p-8">
                    <!-- Animated Icons -->
                    <div class="relative mb-8">
                        <!-- Outer rotating ring -->
                        <div class="absolute inset-0 h-32 w-32 border-4 border-red-200 rounded-full animate-spin"></div>
                        <div class="absolute inset-2 h-28 w-28 border-4 border-red-300 rounded-full animate-spin" style="animation-direction: reverse; animation-duration: 3s;"></div>
                        
                        <!-- Center icon with pulse -->
                        <div class="relative flex items-center justify-center h-32 w-32">
                            <div class="absolute h-20 w-20 bg-red-500 rounded-full animate-pulse"></div>
                            <div class="relative z-10 flex items-center justify-center h-16 w-16 bg-red-600 rounded-full">
                                <i class="fas fa-mobile-alt text-white text-2xl animate-bounce"></i>
                            </div>
                        </div>
                        
                        <!-- Floating dots -->
                        <div class="absolute -top-2 -right-2 h-4 w-4 bg-red-400 rounded-full animate-ping"></div>
                        <div class="absolute -bottom-2 -left-2 h-3 w-3 bg-red-300 rounded-full animate-ping" style="animation-delay: 1s;"></div>
                        <div class="absolute top-1/2 -right-4 h-2 w-2 bg-red-400 rounded-full animate-ping" style="animation-delay: 0.5s;"></div>
                    </div>
                    
                    <h3 class="text-3xl font-bold text-red-800 mb-3">Processing Payment</h3>
                    <p class="text-red-700 text-center mb-2 text-lg">Check your phone for the payment prompt</p>
                    <p class="text-red-600 text-center mb-8 text-sm">Your transaction is being securely processed</p>
                    
                    <!-- Enhanced Progress Bar -->
                    <div class="w-full max-w-md mb-8">
                        <div class="bg-red-200 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-red-500 to-red-600 h-full rounded-full animate-pulse" style="width: 60%;"></div>
                        </div>
                    </div>
                    
                    <!-- Countdown Timer with better styling -->
                    <div class="text-center mb-8">
                        <p class="text-sm text-red-600 mb-3 font-medium uppercase tracking-wider">Time Remaining</p>
                        <div class="bg-white rounded-xl p-4 shadow-lg border-2 border-red-200">
                            <div class="text-4xl font-mono font-bold bg-gradient-to-r from-red-600 to-red-800 bg-clip-text text-transparent">
                                {{ sprintf('%02d:%02d', floor($timeRemaining / 60), $timeRemaining % 60) }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cancel Button with better styling -->
                    <button wire:click="cancelPayment" 
                        class="group px-8 py-4 bg-white text-red-600 font-semibold rounded-xl border-2 border-red-200 hover:bg-red-50 hover:border-red-300 transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fas fa-times mr-3 group-hover:rotate-90 transition-transform duration-200"></i>
                        Cancel Payment
                    </button>
                </div>
            @endif
            
            @if($paymentStatus === 'success')
                <!-- Enhanced Success State -->
                <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-green-100 flex flex-col items-center justify-center z-10 p-8">
                    <!-- Success Animation -->
                    <div class="relative mb-8">
                        <!-- Success rings -->
                        <div class="absolute inset-0 h-32 w-32 border-4 border-green-200 rounded-full animate-ping"></div>
                        <div class="absolute inset-4 h-24 w-24 border-4 border-green-300 rounded-full animate-ping" style="animation-delay: 0.5s;"></div>
                        
                        <!-- Success icon -->
                        <div class="relative flex items-center justify-center h-32 w-32">
                            <div class="absolute h-20 w-20 bg-green-400 rounded-full animate-pulse"></div>
                            <div class="relative z-10 flex items-center justify-center h-16 w-16 bg-green-500 rounded-full">
                                <i class="fas fa-check text-white text-2xl animate-bounce"></i>
                            </div>
                        </div>
                        
                        <!-- Sparkle effects -->
                        <div class="absolute -top-2 -right-2 h-4 w-4 bg-yellow-400 rounded-full animate-ping"></div>
                        <div class="absolute -bottom-2 -left-2 h-3 w-3 bg-yellow-300 rounded-full animate-ping" style="animation-delay: 1s;"></div>
                        <div class="absolute top-1/2 -right-4 h-2 w-2 bg-yellow-400 rounded-full animate-ping" style="animation-delay: 0.5s;"></div>
                    </div>
                    
                    <h3 class="text-3xl font-bold text-green-800 mb-3">Payment Successful!</h3>
                    <p class="text-green-700 text-center mb-8 text-lg">Your payment has been processed successfully</p>
                    
                    <div class="text-center mb-8 bg-white rounded-xl p-6 shadow-lg border-2 border-green-200">
                        <p class="text-sm text-green-600 mb-2 font-medium uppercase tracking-wider">Transaction ID</p>
                        <p class="font-mono text-xl font-bold text-green-800">{{ $payment->order_id ?? 'N/A' }}</p>
                    </div>
                    
                    <button wire:click="closeModal" 
                        class="px-8 py-4 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center">
                        <i class="fas fa-arrow-right mr-3"></i>
                        Continue
                    </button>
                </div>
            @endif
            
            @if($paymentStatus === 'failed')
                <!-- Enhanced Error State -->
                <div class="absolute inset-0 bg-gradient-to-br from-red-50 to-red-100 flex flex-col items-center justify-center z-10 p-8">
                    <!-- Error Animation -->
                    <div class="relative mb-8">
                        <!-- Error rings -->
                        <div class="absolute inset-0 h-32 w-32 border-4 border-red-200 rounded-full animate-ping"></div>
                        <div class="absolute inset-4 h-24 w-24 border-4 border-red-300 rounded-full animate-ping" style="animation-delay: 0.5s;"></div>
                        
                        <!-- Error icon -->
                        <div class="relative flex items-center justify-center h-32 w-32">
                            <div class="absolute h-20 w-20 bg-red-400 rounded-full animate-pulse"></div>
                            <div class="relative z-10 flex items-center justify-center h-16 w-16 bg-red-500 rounded-full">
                                <i class="fas fa-exclamation-triangle text-white text-2xl animate-bounce"></i>
                            </div>
                        </div>
                    </div>
                    
                    <h3 class="text-3xl font-bold text-red-800 mb-3">Payment Failed</h3>
                    <p class="text-red-700 text-center mb-6 text-lg">{{ $errorMessage }}</p>
                    
                    @if($payment && $payment->order_id)
                        <div class="text-center mb-8 bg-white rounded-xl p-6 shadow-lg border-2 border-red-200">
                            <p class="text-sm text-red-600 mb-2 font-medium uppercase tracking-wider">Order ID</p>
                            <p class="font-mono text-xl font-bold text-red-800">{{ $payment->order_id }}</p>
                        </div>
                    @endif
                    
                    <div class="flex space-x-4">
                        <button wire:click="retryPayment" 
                            class="px-8 py-4 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center">
                            <i class="fas fa-redo mr-3"></i>
                            Try Again
                        </button>
                        <button wire:click="closeModal" 
                            class="px-8 py-4 bg-white text-red-600 font-semibold rounded-xl border-2 border-red-200 hover:bg-red-50 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center">
                            <i class="fas fa-times mr-3"></i>
                            Close
                        </button>
                    </div>
                </div>
            @endif

            <!-- Enhanced Loading Spinner for Form Actions -->
            <div wire:loading.delay.long class="absolute inset-0 bg-white bg-opacity-95 flex items-center justify-center z-10 backdrop-blur-sm">
                <div class="text-center">
                    <!-- Multi-layered centered spinner -->
                    <div class="relative mb-8 flex justify-center">
                        <div class="relative">
                            <!-- Outer rotating ring -->
                            <div class="absolute inset-0 h-20 w-20 border-4 border-red-200 rounded-full animate-spin"></div>
                            <div class="absolute inset-1 h-18 w-18 border-4 border-red-300 rounded-full animate-spin" style="animation-direction: reverse; animation-duration: 1.5s;"></div>
                            
                            <!-- Center icon with pulse -->
                            <div class="relative flex items-center justify-center h-20 w-20">
                                <div class="absolute h-12 w-12 bg-red-500 rounded-full animate-pulse"></div>
                                <div class="relative z-10 flex items-center justify-center h-10 w-10 bg-red-600 rounded-full">
                                    <i class="fas fa-cog text-white text-lg animate-spin" style="animation-duration: 2s;"></i>
                                </div>
                            </div>
                            
                            <!-- Floating dots around the spinner -->
                            <div class="absolute -top-1 -right-1 h-3 w-3 bg-red-400 rounded-full animate-ping"></div>
                            <div class="absolute -bottom-1 -left-1 h-2 w-2 bg-red-300 rounded-full animate-ping" style="animation-delay: 0.7s;"></div>
                            <div class="absolute top-1/2 -right-3 h-2 w-2 bg-red-400 rounded-full animate-ping" style="animation-delay: 0.3s;"></div>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Processing Request</h3>
                    <p class="text-gray-600">Please wait while we process your request...</p>
                    
                    <!-- Progress dots -->
                    <div class="flex justify-center space-x-2 mt-4">
                        <div class="h-2 w-2 bg-red-400 rounded-full animate-pulse"></div>
                        <div class="h-2 w-2 bg-red-400 rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
                        <div class="h-2 w-2 bg-red-400 rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
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
                                    class="w-full pl-4 pr-12 py-3 rounded-lg border-gray-200 focus:ring-red-500 focus:border-red-500 shadow-sm"
                                    @if($paymentStatus === 'processing') disabled @endif>
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
                                    class="w-full pl-4 pr-10 py-3 rounded-lg appearance-none border-gray-200 focus:ring-red-500 focus:border-red-500 shadow-sm"
                                    @if($paymentStatus === 'processing') disabled @endif>
                                    <option value="">-- Choose network --</option>
                                    <option value="VODACOM">Vodacom</option>
                                    <option value="TIGO">Tigo</option>
                                    <option value="AIRTEL">Airtel</option>
                                    <option value="HALOTEL">Halotel</option>
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
                                class="w-full pl-4 py-3 rounded-lg border-gray-200 focus:ring-red-500 focus:border-red-500 shadow-sm"
                                @if($paymentStatus === 'processing') disabled @endif>
                            @error('phone') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-2">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" wire:model="acceptTerms" 
                                    class="mt-1 rounded text-red-500 border-gray-300 focus:ring-red-500"
                                    @if($paymentStatus === 'processing') disabled @endif>
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
                @if($paymentStatus !== 'processing')
                    <button wire:click="submitPayment"
                        class="w-full sm:w-auto px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition shadow-sm flex justify-center items-center disabled:opacity-50"
                        @if($paymentStatus === 'processing') disabled @endif>
                        <span>Confirm & Pay</span>
                        <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                @endif
                
                @if($paymentStatus !== 'processing')
                    <button wire:click="closeModal" 
                        class="w-full sm:w-auto px-6 py-3 bg-white text-gray-600 font-medium rounded-lg border border-gray-200 hover:bg-gray-50 transition flex justify-center items-center">
                        <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Cancel</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
@endif

</div>