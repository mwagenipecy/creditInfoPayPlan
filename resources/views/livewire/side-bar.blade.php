<div>
<aside id="sidebar" class="fixed md:relative z-40 w-72 h-screen bg-white shadow-lg transform md:translate-x-0 -translate-x-full transition-transform duration-300 ease-in-out">
    <div class="h-full flex flex-col">
      <!-- Logo -->
      <div class="flex-shrink-0 px-6 py-5 border-b border-gray-100 flex items-center justify-center space-x-2">
        <img src="{{ asset('/creditInfoLogo.svg') }}" alt="InfoSec Company Logo" class="h-8" />
      </div>

      <!-- User Profile -->
      <div class="flex-shrink-0 px-6 py-4 border-b border-gray-100">
        <div class="flex items-center space-x-3">
          <div class="relative">
            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->first_name }}+{{ auth()->user()->last_name }}&background=C40F12&color=fff&bold=true"
                 class="w-10 h-10 rounded-full border-2 border-red-100" />
            <span class="pulse-notification"></span>
          </div>
          <div>
            <h4 class="font-medium text-gray-800">{{ auth()->user()->name }}</h4>
            <p class="text-xs text-gray-500"> {{ DB::table('roles')->where('id', auth()->user()->role_id)->first()?->display_name ?? "System User" }} </p>
          </div>
        </div>
      </div>

      <!-- Navigation - Scrollable Section -->
      <nav class="flex-1 overflow-y-auto px-4 py-5 space-y-1">
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
        
        @if(\App\Helpers\MenuHelper::canAccessMenu('payment'))

        <a href="{{ route('payment.plan') }}" data-page="payments" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
          <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
            <i class="fas fa-credit-card nav-icon"></i>
          </span>
          <span class="ml-3 link-text">Payments</span>
        </a>

        @else

        <a href="#" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-400 cursor-not-allowed pointer-events-none">
          <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-400">
            <i class="fas fa-credit-card nav-icon"></i>
          </span>
          <span class="ml-3 link-text">Payments</span>
        </a>

        @endif 

        <div class="relative sidebar-dropdown">
          <button id="packages-toggle" 
                  class="sidebar-link flex items-center justify-between w-full px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
            <div class="flex items-center">
              <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
                <i class="fas fa-box nav-icon"></i>
              </span>
              <span class="ml-3 link-text">My Packages</span>
            </div>
            <span class="ml-auto transition-transform duration-200 packages-chevron">
              <i class="fas fa-chevron-down text-xs"></i>
            </span>
          </button>
          
          <!-- Dropdown Menu -->
          <div id="packages-dropdown" 
               class="mt-1 ml-8 space-y-1 hidden transition-all duration-200 opacity-0 transform scale-y-95">
            
            <!-- Active Packages -->
            <a href="{{ route('package.active') }}" 
               class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-[#C40F12] group">
              <span class="inline-flex items-center justify-center h-6 w-6 text-xs text-gray-400 group-hover:text-[#C40F12]">
                <i class="fas fa-check-circle"></i>
              </span>
              <span class="ml-2 link-text">Active Packages</span>
            </a>
            
            <!-- Expired Packages -->
            <a href="{{ route('expired.package') }}" 
               class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-[#C40F12] group">
              <span class="inline-flex items-center justify-center h-6 w-6 text-xs text-gray-400 group-hover:text-[#C40F12]">
                <i class="fas fa-times-circle"></i>
              </span>
              <span class="ml-2 link-text">Expired Packages</span>
            </a>
            
            <!-- Usage History -->
            <a href="{{ route('usage.history') }}" 
               class="sidebar-link flex items-center px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-[#C40F12] group">
              <span class="inline-flex items-center justify-center h-6 w-6 text-xs text-gray-400 group-hover:text-[#C40F12]">
                <i class="fas fa-history"></i>
              </span>
              <span class="ml-2 link-text">Usage History</span>
            </a>
          </div>
        </div>

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
        
        <a href="{{ route('payment.log') }}" data-page="Payment Logs" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
          <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
            <i class="fas fa-file-invoice nav-icon"></i>
          </span>
          <span class="ml-3 link-text">Payment Log</span>
        </a>
        
        <a href="#" data-page="support" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
          <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
            <i class="fas fa-headset nav-icon"></i>
          </span>
          <span class="ml-3 link-text">Support</span>
        </a>
        
        <a href="{{ route('admin.callbacks') }}" data-page="settings" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
          <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
            <i class="fas fa-cog nav-icon"></i>
          </span>
          <span class="ml-3 link-text"> Payment Callback</span>
        </a>
      </nav>

      <!-- Logout - Fixed at bottom -->
      <div class="flex-shrink-0 p-4 border-t border-gray-100">
        <button class="w-full flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:text-[#C40F12] hover:bg-red-50 rounded-lg transition-colors">
          <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500">
            <i class="fas fa-sign-out-alt"></i>
          </span>
          <span class="ml-3">Logout</span>
        </button>
      </div>
    </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('packages-toggle');
    const dropdown = document.getElementById('packages-dropdown');
    const chevron = document.querySelector('.packages-chevron');
    
    toggle.addEventListener('click', function() {
        const isHidden = dropdown.classList.contains('hidden');
        
        if (isHidden) {
            dropdown.classList.remove('hidden');
            setTimeout(() => {
                dropdown.classList.remove('opacity-0', 'scale-y-95');
                dropdown.classList.add('opacity-100', 'scale-y-100');
                chevron.classList.add('rotate-180');
            }, 10);
        } else {
            dropdown.classList.remove('opacity-100', 'scale-y-100');
            dropdown.classList.add('opacity-0', 'scale-y-95');
            chevron.classList.remove('rotate-180');
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 200);
        }
    });
});
</script>

</div>