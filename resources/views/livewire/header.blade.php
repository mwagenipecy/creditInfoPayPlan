<div>
 <!-- Top Navbar -->
 <header class="bg-white border-b border-gray-100 sticky top-0 z-20">
      <div class="flex items-center justify-between px-6 py-4">
        <div class="flex items-center gap-4">
          <button onclick="toggleSidebar()" class="text-gray-600 md:hidden focus:outline-none hover:text-[#C40F12] transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
          <h1 id="page-title" class="text-xl font-semibold text-gray-800">Dashboard</h1>
        </div>

        <!-- Search & Actions -->
        <div class="hidden md:flex items-center space-x-4 flex-1 max-w-md mx-8">
          <div class="relative flex-1">
            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
              <i class="fas fa-search"></i>
            </span>
            <input type="text" placeholder="Search..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 text-sm" />
          </div>
        </div>

        <!-- User Info / Actions -->
        <div class="flex items-center space-x-4">
          <!-- Notifications -->
          <button class="relative p-2 text-gray-500 hover:text-[#C40F12] rounded-full hover:bg-red-50 transition-colors">
            <i class="fas fa-bell"></i>
            <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
          </button>
          
          <!-- Messages -->
          <button class="relative p-2 text-gray-500 hover:text-[#C40F12] rounded-full hover:bg-red-50 transition-colors">
            <i class="fas fa-envelope"></i>
          </button>
          
          <!-- Divider -->
          <div class="h-8 border-l border-gray-200"></div>
          
          <!-- User dropdown -->
          <div class="relative">
            <div onclick="toggleUserMenu()" class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded-lg">
              <img src="https://ui-avatars.com/api/?name={{ auth()->user()->first_name }}+{{ auth()->user()->last_name }}&background=C40F12&color=fff&bold=true"
                   class="w-8 h-8 rounded-full border border-gray-200 shadow-sm" />
              <div class="hidden md:block">
                <div class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-500">{{ auth()->user()->email }}</div>
              </div>
              <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </div>
            
            <!-- Dropdown Menu -->
            <div id="userDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 hidden z-50">
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#C40F12]">
                <i class="fas fa-user mr-2"></i> Profile
              </a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#C40F12]">
                <i class="fas fa-cog mr-2"></i> Settings
              </a>
              <div class="border-t border-gray-100 my-1"></div>
              <!-- Laravel Logout Form -->
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
              </form>
              <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                 class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 font-medium">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
              </a>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Add the JavaScript for the dropdown functionality -->
    <script>
      function toggleUserMenu() {
        const menu = document.getElementById('userDropdownMenu');
        menu.classList.toggle('hidden');
      }
      
      // Close the dropdown when clicking outside
      window.addEventListener('click', function(event) {
        const menu = document.getElementById('userDropdownMenu');
        const userDropdown = event.target.closest('.relative');
        
        if (!userDropdown && !menu.classList.contains('hidden')) {
          menu.classList.add('hidden');
        }
      });
    </script>
</div>

