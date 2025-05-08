<div>
<aside id="sidebar" class="fixed md:relative z-40 w-72 min-h-screen  bg-white shadow-lg transform md:translate-x-0 -translate-x-full transition-transform duration-300 ease-in-out h-full overflow-y-auto">
    <div class="h-full flex flex-col">
      <!-- Logo -->
      <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-center space-x-2">
       
        <img src="{{ asset('/creditInfoLogo.svg') }}" alt="InfoSec Company Logo" class="h-8" />
        </div>

      <!-- User Profile -->
      <div class="px-6 py-4 border-b border-gray-100">
        <div class="flex items-center space-x-3">
          <div class="relative">
            <img src="https://ui-avatars.com/api/?name=Admin+User&background=C40F12&color=fff&bold=true"
                 class="w-10 h-10 rounded-full border-2 border-red-100" />
            <span class="pulse-notification"></span>
          </div>
          <div>
            <h4 class="font-medium text-gray-800">{{ auth()->user()->name }}</h4>
            <p class="text-xs text-gray-500">System Administrator</p>
          </div>
        </div>
      </div>

      <!-- Navigation -->
<!-- Navigation -->
<nav class="flex-1 px-4 py-5 space-y-1">
  <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Main</p>
  
  <a href="{{ route('dashboard') }}" data-page="dashboard" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
    <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
      <i class="fas fa-tachometer-alt nav-icon"></i>
    </span>
    <span class="ml-3 link-text">Dashboard</span>
  </a>

  <a href="{{ route('document.list') }}" data-page="verification" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
    <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
      <i class="fas fa-file-upload nav-icon"></i>
    </span>
    <span class="ml-3 link-text">Document Verification</span>
    <span class="ml-auto bg-red-100 text-red-600 text-xs font-medium px-2 py-1 rounded-full">Required</span>
  </a>
  
  <a href="{{ route('payment.plan') }}" data-page="payments" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
    <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
      <i class="fas fa-credit-card nav-icon"></i>
    </span>
    <span class="ml-3 link-text">Payments</span>
  </a>

  <a href="{{ route('credit.report') }}" data-page="credit-report" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
  <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
    <i class="fas fa-file-alt nav-icon"></i>
  </span>
  <span class="ml-3 link-text">Credit Report</span>
</a>


  <a href="{{ route('user.list') }}" data-page="users" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
    <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
      <i class="fas fa-users nav-icon"></i>
    </span>
    <span class="ml-3 link-text">User Management</span>
    <span class="ml-auto bg-green-100 text-green-600 text-xs font-medium px-2 py-1 rounded-full">New</span>
  </a>
  
  <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Analytics</p>
  
  <a href="{{ route('usage.dashboard') }}" data-page="reports" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
    <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
      <i class="fas fa-chart-line nav-icon"></i>
    </span>
    <span class="ml-3 link-text">Usage Reports</span>
  </a>
  
  <a href="#" data-page="statements" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
    <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
      <i class="fas fa-file-invoice nav-icon"></i>
    </span>
    <span class="ml-3 link-text">Statements</span>
  </a>
  
  <a href="#" data-page="support" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
    <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
      <i class="fas fa-headset nav-icon"></i>
    </span>
    <span class="ml-3 link-text">Support</span>
  </a>
  
  <a href="#" data-page="settings" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
    <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
      <i class="fas fa-cog nav-icon"></i>
    </span>
    <span class="ml-3 link-text">Settings</span>
  </a>
</nav>

      <!-- Logout -->
      <div class="p-4 border-t border-gray-100">
        <button class="w-full flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:text-[#C40F12] hover:bg-red-50 rounded-lg transition-colors">
          <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500">
            <i class="fas fa-sign-out-alt"></i>
          </span>
          <span class="ml-3">Logout</span>
        </button>
      </div>
    </div>
  </aside>
</div>





