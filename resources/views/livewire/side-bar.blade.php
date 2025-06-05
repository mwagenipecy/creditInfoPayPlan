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

          @if(auth()->user()->company->verification_status ?? "N/A" != "approved")
          <span class="ml-auto bg-red-100 text-red-600 text-xs font-medium px-2 py-1 rounded-full"> Required </span>
          @endif 


        </a>



        @if(auth()->user()->company->verification_status ?? "N/A" == 'approved' || auth()->user()->role->name == 'super_admin')
    <a href="{{ route('payment.plan') }}" data-page="payments" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
        <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
            <i class="fas fa-credit-card nav-icon"></i>
        </span>
        <span class="ml-3 link-text">Payments</span>
    </a>
          @else
              <div class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-400 cursor-not-allowed relative group" title="Company verification required">
                  <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-400 relative">
                      <i class="fas fa-credit-card nav-icon"></i>
                      <i class="fas fa-lock absolute -top-1 -right-1 text-xs text-red-500 bg-white rounded-full p-0.5"></i>
                  </span>
                  <span class="ml-3 link-text">Payments</span>
                  <span class="ml-auto text-xs text-red-500 font-medium bg-red-50 px-2 py-1 rounded-full">Locked</span>
              </div>
          @endif

{{-- Reports Dropdown Menu --}}
@if(auth()->user()->company->verification_status ?? "N/A" == 'approved' )
    <div class="relative sidebar-dropdown">
        <button id="packages-toggle" 
                class="sidebar-link flex items-center justify-between w-full px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
            <div class="flex items-center">
                <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
                    <i class="fas fa-box nav-icon"></i>
                </span>
                <span class="ml-3 link-text">Reports</span>
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
@else
    <div class="sidebar-link flex items-center justify-between w-full px-4 py-3 rounded-lg text-sm font-medium text-gray-400 cursor-not-allowed relative group" title="Company verification required">
        <div class="flex items-center">
            <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-400 relative">
                <i class="fas fa-box nav-icon"></i>
                <i class="fas fa-lock absolute -top-1 -right-1 text-xs text-red-500 bg-white rounded-full p-0.5"></i>
            </span>
            <span class="ml-3 link-text">Reports</span>
        </div>
        <span class="ml-auto text-xs text-red-500 font-medium bg-red-50 px-2 py-1 rounded-full">Locked</span>
    </div>
@endif

{{-- Credit Report Menu --}}
@if(
    (auth()->user()->company->verification_status ?? 'N/A') == 'approved' &&
    DB::table('accounts')
        ->where('company_id', auth()->user()->company_id)
        ->where('status', 'active')
        ->where('valid_until', '>', now())
        ->exists()  
)


    <a href="{{ route('credit.report') }}" data-page="credit-report" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
        <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
            <i class="fas fa-file-alt nav-icon"></i>
        </span>
        <span class="ml-3 link-text">Credit Report</span>
    </a>
@else
    <div class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-400 cursor-not-allowed relative group" title="Company verification required">
        <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-400 relative">
            <i class="fas fa-file-alt nav-icon"></i>
            <i class="fas fa-lock absolute -top-1 -right-1 text-xs text-red-500 bg-white rounded-full p-0.5"></i>
        </span>
        <span class="ml-3 link-text">Credit Report</span>
        <span class="ml-auto text-xs text-red-500 font-medium bg-red-50 px-2 py-1 rounded-full">Locked</span>
    </div>
@endif

{{-- User Management Menu --}}
@if(auth()->user()->company->verification_status ?? "N/A" == 'approved' || auth()->user()->role->name == 'super_admin')
    <a href="{{ route('user.list') }}" data-page="users" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
        <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
            <i class="fas fa-users nav-icon"></i>
        </span>
        <span class="ml-3 link-text">User Management</span>
        <span class="ml-auto bg-green-100 text-green-600 text-xs font-medium px-2 py-1 rounded-full">New</span>
    </a>
@else
    <div class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-400 cursor-not-allowed relative group" title="Company verification required">
        <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-400 relative">
            <i class="fas fa-users nav-icon"></i>
            <i class="fas fa-lock absolute -top-1 -right-1 text-xs text-red-500 bg-white rounded-full p-0.5"></i>
        </span>
        <span class="ml-3 link-text">User Management</span>
        <span class="ml-auto text-xs text-red-500 font-medium bg-red-50 px-2 py-1 rounded-full">Locked</span>
    </div>
@endif



        @if(auth()->user()->role_id==1)
        
        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Analytics</p>
        
        <a href="{{ route('payment.log') }}" data-page="Payment Logs" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
          <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
            <i class="fas fa-file-invoice nav-icon"></i>
          </span>
          <span class="ml-3 link-text">Payment Log</span>
        </a>
        
        <!-- <a href="#" data-page="support" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
          <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
            <i class="fas fa-headset nav-icon"></i>
          </span>
          <span class="ml-3 link-text">Support</span>
        </a> -->
        
        <a href="{{ route('admin.callbacks') }}" data-page="settings" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
          <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
            <i class="fas fa-cog nav-icon"></i>
          </span>
          <span class="ml-3 link-text"> Payment Callback</span>
        </a>

        @endif 


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



<style>
.locked-overlay {
    position: relative;
}

.locked-overlay::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(1px);
    border-radius: 0.5rem;
    pointer-events: none;
}

.locked-overlay .lock-icon {
    position: absolute;
    top: 50%;
    right: 8px;
    transform: translateY(-50%);
    z-index: 10;
    background: white;
    border-radius: 50%;
    padding: 2px;
}
</style>




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


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event to locked items to show alert
    const lockedItems = document.querySelectorAll('.cursor-not-allowed');
    
    lockedItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Create and show a toast notification
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-opacity duration-300';
            toast.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-lock mr-2"></i>
                    <span>Company verification / payments required to access this feature</span>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Remove toast after 3 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        });
    });
});
</script>




</div>