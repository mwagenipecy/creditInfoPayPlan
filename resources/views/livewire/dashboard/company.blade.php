<div>


<!-- Page Header -->
<div class="mb-6">
  <h2 class="text-2xl font-bold text-gray-800">Welcome Back, <span>{{ 'company.name' }}</span>!</h2>
  <p class="text-sm text-gray-600 mt-1">
    <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs mr-2">Account Status: Pending Verification</span>
    Complete your registration to access all features.
  </p>
</div>

<!-- Registration Progress -->
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-lg font-bold text-gray-800">Registration Progress</h2>
    <span class="text-sm font-medium text-gray-500">2 of 4 Steps Complete</span>
  </div>
  
  <!-- Progress Bar -->
  <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
    <div class="bg-[#C40F12] h-2.5 rounded-full" style="width: 50%"></div>
  </div>
  
  <!-- Progress Steps -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="p-4 bg-green-50 rounded-lg border border-green-100 text-sm">
      <div class="flex items-center">
        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-500 text-white mr-3">
          <i class="fas fa-check"></i>
        </span>
        <div>
          <p class="font-medium text-green-800">Step 1: Registration</p>
          <p class="mt-1 text-green-600">Account created successfully</p>
        </div>
      </div>
    </div>
    
    <div class="p-4 bg-green-50 rounded-lg border border-green-100 text-sm">
      <div class="flex items-center">
        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-500 text-white mr-3">
          <i class="fas fa-check"></i>
        </span>
        <div>
          <p class="font-medium text-green-800">Step 2: Profile Setup</p>
          <p class="mt-1 text-green-600">Profile information completed</p>
        </div>
      </div>
    </div>
    
    <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-100 text-sm">
      <div class="flex items-center">
        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-yellow-500 text-white mr-3">
          <i class="fas fa-clock"></i>
        </span>
        <div>
          <p class="font-medium text-yellow-800">Step 3: Verification</p>
          <p class="mt-1 text-yellow-600">Documents under review</p>
        </div>
      </div>
    </div>
    
    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 text-sm">
      <div class="flex items-center">
        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-300 text-white mr-3">
          <i class="fas fa-lock"></i>
        </span>
        <div>
          <p class="font-medium text-gray-600">Step 4: Payment</p>
          <p class="mt-1 text-gray-500">Unlocked after verification</p>
        </div>
      </div>
    </div>
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
      <span class="text-2xl font-bold text-gray-800">0</span>
      <span class="ml-2 text-xs font-medium text-gray-500">Requests</span>
    </div>
    <div class="text-xs text-gray-500 mt-2">Statements requested this month</div>
    
    <div class="mt-4 pt-4 border-t border-gray-100">
      <div class="flex items-center justify-between text-xs text-gray-500">
        <span>Plan Limit:</span>
        <span class="font-medium">0 / 0</span>
      </div>
      <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
        <div class="bg-purple-500 h-1.5 rounded-full" style="width: 0%"></div>
      </div>
      <div class="text-xs text-gray-500 mt-2">Subscription not active</div>
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
      <span class="text-2xl font-bold text-gray-800">$0.00</span>
      <span class="ml-2 text-xs font-medium text-gray-500">USD</span>
    </div>
    <div class="text-xs text-gray-500 mt-2">Total amount paid</div>
    
    <div class="mt-4 pt-4 border-t border-gray-100">
      <div class="flex items-center justify-between text-xs">
        <span class="text-gray-500">Subscription:</span>
        <span class="font-medium text-yellow-600 px-2 py-1 bg-yellow-50 rounded-full">Not Active</span>
      </div>
      <div class="flex items-center justify-between text-xs mt-2">
        <span class="text-gray-500">Next Payment:</span>
        <span class="font-medium text-gray-600">N/A</span>
      </div>
      <div class="flex items-center justify-between text-xs mt-2">
        <span class="text-gray-500">Payment Method:</span>
        <span class="font-medium text-gray-600">None</span>
      </div>
    </div>
  </div>
</div>

<!-- Action Required -->
<div class="bg-white rounded-xl shadow-sm p-6 border border-red-200 mb-8">
  <div class="flex items-start">
    <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-red-100 text-[#C40F12] mr-4">
      <i class="fas fa-exclamation-circle text-xl"></i>
    </span>
    <div>
      <h3 class="text-lg font-bold text-gray-800">Action Required: Document Verification</h3>
      <p class="text-sm text-gray-600 mt-1">Please upload the following documents to complete your verification:</p>
      <ul class="mt-3 space-y-2 text-sm">
        <li class="flex items-center">
          <i class="fas fa-file-pdf text-[#C40F12] mr-2"></i>
          <span>Company Registration Certificate</span>
          <span class="ml-2 px-2 py-1 rounded-full bg-red-100 text-red-600 text-xs">Required</span>
        </li>
        <li class="flex items-center">
          <i class="fas fa-file-invoice text-[#C40F12] mr-2"></i>
          <span>Tax Identification Document</span>
          <span class="ml-2 px-2 py-1 rounded-full bg-red-100 text-red-600 text-xs">Required</span>
        </li>
        <li class="flex items-center">
          <i class="fas fa-id-card text-[#C40F12] mr-2"></i>
          <span>Director's ID Proof</span>
          <span class="ml-2 px-2 py-1 rounded-full bg-red-100 text-red-600 text-xs">Required</span>
        </li>
      </ul>
      <div class="mt-4">
        <button class="px-4 py-2 bg-[#C40F12] text-white rounded-lg text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors">
          <i class="fas fa-upload mr-2"></i> Upload Documents
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Upcoming Features -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
  <!-- User Management Preview -->
  <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-medium text-gray-800">User Management</h3>
      <span class="p-2 bg-gray-100 text-gray-600 rounded-lg">
        <i class="fas fa-users"></i>
      </span>
    </div>
    <p class="text-sm text-gray-600 mb-4">After verification and payment, you'll be able to add and manage users in your organization.</p>
    <div class="flex items-center justify-between">
      <span class="text-xs font-medium text-gray-500">Available after payment</span>
      <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-500 text-xs">Locked</span>
    </div>
  </div>
  
  <!-- Reports Preview -->
  <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-medium text-gray-800">Usage Reports</h3>
      <span class="p-2 bg-gray-100 text-gray-600 rounded-lg">
        <i class="fas fa-chart-line"></i>
      </span>
    </div>
    <p class="text-sm text-gray-600 mb-4">Track your credit information usage and generate detailed reports for your organization.</p>
    <div class="flex items-center justify-between">
      <span class="text-xs font-medium text-gray-500">Available after payment</span>
      <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-500 text-xs">Locked</span>
    </div>
  </div>
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
        <p class="mt-1">Email us at support@creditinfo.com or call our helpline at +1 (800) 123-4567</p>
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
