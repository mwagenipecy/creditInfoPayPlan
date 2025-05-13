<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Welcome Back, <span>{{ auth()->user()->name }}</span>!</h2>
        <p class="text-sm text-gray-600 mt-1">
            <span class="px-2 py-1 rounded-full 
                {{ $accountStatus['color'] === 'green' ? 'bg-green-100 text-green-700' : 
                   ($accountStatus['color'] === 'yellow' ? 'bg-yellow-100 text-yellow-700' : 
                   ($accountStatus['color'] === 'blue' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700')) }} 
                text-xs mr-2">
                Account Status: {{ $accountStatus['text'] }}
            </span>
            {{ $accountStatus['status'] === 'active' ? 'Your account is fully active and ready to use.' : 'Complete your registration to access all features.' }}
        </p>
    </div>

    <!-- Registration Progress -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-800">Registration Progress</h2>
            <span class="text-sm font-medium text-gray-500">
                {{ $registrationProgress['completedSteps'] }} of {{ $registrationProgress['totalSteps'] }} Steps Complete
            </span>
        </div>
        
        <!-- Progress Bar -->
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
            <div class="bg-[#C40F12] h-2.5 rounded-full" style="width: {{ $registrationProgress['percentage'] }}%"></div>
        </div>
        
        <!-- Progress Steps -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($registrationProgress['steps'] as $key => $step)
                <div class="p-4 {{ $step['completed'] ? 'bg-green-50 border-green-100' : 'bg-gray-50 border-gray-200' }} rounded-lg border text-sm">
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full 
                            {{ $step['completed'] ? 'bg-green-500 text-white' : 'bg-gray-300 text-white' }} mr-3">
                            <i class="{{ $step['icon'] }}"></i>
                        </span>
                        <div>
                            <p class="font-medium {{ $step['completed'] ? 'text-green-800' : 'text-gray-600' }}">
                                Step {{ $loop->iteration }}: {{ $step['title'] }}
                            </p>
                            <p class="mt-1 {{ $step['completed'] ? 'text-green-600' : 'text-gray-500' }}">
                                {{ $step['description'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Usage and Payment Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Statement Requests Stats -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500">Statement Requests</h3>
                <span class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                    <i class="fas fa-file-alt"></i>
                </span>
            </div>
            <div class="flex items-baseline">
                <span class="text-2xl font-bold text-gray-800">{{ number_format($statementStats['total_requests']) }}</span>
                <span class="ml-2 text-xs font-medium text-gray-500">Requests</span>
            </div>
            <div class="text-xs text-gray-500 mt-2">Statements requested this month</div>
            
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <span>Plan Limit:</span>
                    <span class="font-medium">{{ number_format($statementStats['total_requests']) }} / {{ number_format($statementStats['plan_limit']) }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                    <div class="bg-purple-500 h-1.5 rounded-full" style="width: {{ $statementStats['usage_percentage'] }}%"></div>
                </div>
                <div class="text-xs text-gray-500 mt-2">
                    {{ $statementStats['status'] === 'active' ? $statementStats['remaining'] . ' requests remaining' : 'Subscription not active' }}
                </div>
            </div>
        </div>
        
        <!-- Payment Stats -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500">Payment Status</h3>
                <span class="p-2 bg-green-100 text-green-600 rounded-lg">
                    <i class="fas fa-credit-card"></i>
                </span>
            </div>
            <div class="flex items-baseline">
                <span class="text-2xl font-bold text-gray-800">{{ number_format($paymentStats['total_paid'], 2) }}</span>
                <span class="ml-2 text-xs font-medium text-gray-500">TZS</span>
            </div>
            <div class="text-xs text-gray-500 mt-2">Total amount paid</div>
            
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-gray-500">Subscription:</span>
                    <span class="font-medium 
                        {{ $paymentStats['subscription_status'] === 'active' ? 'text-green-600 bg-green-50' : 'text-yellow-600 bg-yellow-50' }} 
                        px-2 py-1 rounded-full">
                        {{ $paymentStats['subscription_status'] === 'active' ? 'Active' : 'Not Active' }}
                    </span>
                </div>
                <div class="flex items-center justify-between text-xs mt-2">
                    <span class="text-gray-500">Next Payment:</span>
                    <span class="font-medium text-gray-600">{{ $paymentStats['next_payment'] ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center justify-between text-xs mt-2">
                    <span class="text-gray-500">Payment Method:</span>
                    <span class="font-medium text-gray-600">{{ $paymentStats['payment_method'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Required -->
    @if($accountStatus['status'] === 'pending_verification' || $accountStatus['status'] === 'rejected')
        <div class="bg-white rounded-xl shadow-sm p-6 border border-red-200 mb-8">
            <div class="flex items-start">
                <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-red-100 text-[#C40F12] mr-4">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                </span>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">
                        Action Required: 
                        {{ $accountStatus['status'] === 'rejected' ? 'Document Re-submission' : 'Document Verification' }}
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ $accountStatus['status'] === 'rejected' ? 'Your documents were rejected. Please re-upload the following documents:' : 'Please upload the following documents to complete your verification:' }}
                    </p>
                    <ul class="mt-3 space-y-2 text-sm">
                        @foreach($requiredDocuments as $document)
                            <li class="flex items-center">
                                <i class="{{ $document['icon'] }} text-[#C40F12] mr-2"></i>
                                <span>{{ $document['name'] }}</span>
                                <span class="ml-2 px-2 py-1 rounded-full 
                                    {{ $document['status'] === 'uploaded' ? 'bg-green-100 text-green-600' :
                                       ($document['status'] === 'approved' ? 'bg-green-100 text-green-600' :
                                       ($document['status'] === 'rejected' ? 'bg-red-100 text-red-600' : 'bg-red-100 text-red-600')) }} 
                                    text-xs">
                                    {{ $document['status'] === 'uploaded' ? 'Uploaded' :
                                       ($document['status'] === 'approved' ? 'Approved' :
                                       ($document['status'] === 'rejected' ? 'Rejected' : 'Required')) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-4">
                        <button class="px-4 py-2 bg-[#C40F12] text-white rounded-lg text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors">
                            <i class="fas fa-upload mr-2"></i> 
                            {{ $accountStatus['status'] === 'rejected' ? 'Re-upload Documents' : 'Upload Documents' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @elseif($accountStatus['status'] === 'under_review')
        <div class="bg-white rounded-xl shadow-sm p-6 border border-blue-200 mb-8">
            <div class="flex items-start">
                <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-clock text-xl"></i>
                </span>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Documents Under Review</h3>
                    <p class="text-sm text-gray-600 mt-1">We are currently reviewing your submitted documents. This process typically takes 2-3 business days.</p>
                    <div class="mt-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                            You will receive an email notification once the review is complete.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif($accountStatus['status'] === 'pending_payment')
        <div class="bg-white rounded-xl shadow-sm p-6 border border-orange-200 mb-8">
            <div class="flex items-start">
                <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-orange-100 text-orange-600 mr-4">
                    <i class="fas fa-credit-card text-xl"></i>
                </span>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Payment Required</h3>
                    <p class="text-sm text-gray-600 mt-1">Your documents have been verified. Please complete your subscription payment to activate your account.</p>
                    <div class="mt-4">
                        <button class="px-4 py-2 bg-[#C40F12] text-white rounded-lg text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors">
                            <i class="fas fa-money-bill mr-2"></i> Complete Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Upcoming Features -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        @foreach($features as $featureKey => $feature)
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-800">{{ $feature['title'] }}</h3>
                    <span class="p-2 {{ $feature['available'] ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600' }} rounded-lg">
                        <i class="{{ $feature['icon'] }}"></i>
                    </span>
                </div>
                <p class="text-sm text-gray-600 mb-4">{{ $feature['description'] }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500">
                        {{ $feature['available'] ? 'Available now' : 'Available after payment' }}
                    </span>
                    <span class="px-2 py-1 rounded-full {{ $feature['available'] ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }} text-xs">
                        {{ $feature['available'] ? 'Active' : 'Locked' }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Help & Support -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800">Need Help?</h2>
            <span class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                <i class="fas fa-headset"></i>
            </span>
        </div>
        <p class="text-sm text-gray-600 mb-4">Our support team is available to assist you with the registration process or answer any questions.</p>
        <div class="p-4 bg-blue-50 rounded-lg border border-blue-100 text-sm text-blue-800">
            <div class="flex items-start">
                <span class="mr-3 text-blue-500">
                    <i class="fas fa-info-circle text-lg"></i>
                </span>
                <div>
                    <p class="font-medium">Contact Support</p>
                    <p class="mt-1">Email us at support@creditinfo.co.tz or call our helpline at +255 22 266 6226</p>
                </div>
            </div>
        </div>
        <div class="mt-4 flex justify-end">
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition-colors">
                <i class="fas fa-question-circle mr-2"></i> View FAQs
            </button>
            <button class="ml-3 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50 transition-colors">
                <i class="fas fa-envelope mr-2"></i> Contact Support
            </button>
        </div>
    </div>
</div>