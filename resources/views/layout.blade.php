<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - CreditInfo</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    body {
      font-family: 'Poppins', sans-serif;
    }
    
    .sidebar-link {
      transition: all 0.3s ease;
    }
    
    .sidebar-link.active {
      background-color: #FEE2E2;
      color: #C40F12;
      border-left: 4px solid #C40F12;
    }
    
    .nav-icon {
      transition: transform 0.2s;
    }
    
    .sidebar-link:hover .nav-icon {
      transform: translateX(3px);
    }
    
    .pulse-notification {
      position: absolute;
      top: -2px;
      right: -2px;
      height: 8px;
      width: 8px;
      border-radius: 50%;
      background-color: #C40F12;
      animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
      0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(196, 15, 18, 0.7);
      }
      70% {
        transform: scale(1);
        box-shadow: 0 0 0 6px rgba(196, 15, 18, 0);
      }
      100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(196, 15, 18, 0);
      }
    }
    
    .stat-card {
      transition: all 0.3s ease;
    }
    
    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
  </style>
  <script defer>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('-translate-x-full');
      document.getElementById('overlay').classList.toggle('hidden');
    }
    
    document.addEventListener('DOMContentLoaded', function() {
      // Set dashboard as active by default
      document.querySelector('.sidebar-link[data-page="dashboard"]').classList.add('active');
      
      // Add click event listeners to sidebar links
      document.querySelectorAll('.sidebar-link').forEach(link => {
        link.addEventListener('click', function(e) {
          // Prevent default only in demo
          e.preventDefault();
          
          // Remove active class from all links
          document.querySelectorAll('.sidebar-link').forEach(el => {
            el.classList.remove('active');
          });
          
          // Add active class to clicked link
          this.classList.add('active');
          
          // Update header title
          document.getElementById('page-title').innerText = this.querySelector('.link-text').innerText;
          
          // Close sidebar on mobile after navigation
          if (window.innerWidth < 768) {
            toggleSidebar();
          }
        });
      });
    });
  </script>



 <!-- Scripts -->
 @vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Styles -->
@livewireStyles



</head>
<body class="bg-gray-50 text-gray-800">

<!-- Dark Overlay (Mobile Only) -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden" onclick="toggleSidebar()"></div>

<!-- Layout Wrapper -->
<div class="min-h-screen flex overflow-hidden">

  <!-- Sidebar -->
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
            <h4 class="font-medium text-gray-800">Admin User</h4>
            <p class="text-xs text-gray-500">System Administrator</p>
          </div>
        </div>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 px-4 py-5 space-y-1">
        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Main</p>
        
        <a href="#" data-page="dashboard" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
          <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
            <i class="fas fa-tachometer-alt nav-icon"></i>
          </span>
          <span class="ml-3 link-text">Dashboard</span>
        </a>
        
        <a href="#" data-page="users" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
          <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
            <i class="fas fa-users nav-icon"></i>
          </span>
          <span class="ml-3 link-text">Users</span>
          <span class="ml-auto bg-red-100 text-red-600 text-xs font-medium px-2 py-1 rounded-full">12</span>
        </a>
        
        <a href="#" data-page="statements" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
          <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
            <i class="fas fa-file-invoice nav-icon"></i>
          </span>
          <span class="ml-3 link-text">Statements</span>
        </a>
        
        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Analytics</p>
        
        <a href="#" data-page="reports" class="sidebar-link flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#C40F12] group">
          <span class="inline-flex items-center justify-center h-8 w-8 text-lg text-gray-500 group-hover:text-[#C40F12]">
            <i class="fas fa-chart-line nav-icon"></i>
          </span>
          <span class="ml-3 link-text">Reports</span>
          <span class="ml-auto bg-green-100 text-green-600 text-xs font-medium px-2 py-1 rounded-full">New</span>
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

  <!-- Main content -->
  <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">

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
          <div class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded-lg">
            <img src="https://ui-avatars.com/api/?name=A+User&background=C40F12&color=fff&bold=true"
                 class="w-8 h-8 rounded-full border border-gray-200 shadow-sm" />
            <div class="hidden md:block">
              <div class="text-sm font-medium text-gray-700">Admin User</div>
              <div class="text-xs text-gray-500">admin@creditinfo.com</div>
            </div>
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </div>
        </div>
      </div>
    </header>

    <!-- Page Content Area -->
    <main class="flex-1 p-6 lg:p-8 bg-gray-50">
      <!-- Page Header -->
      <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Welcome Back, Admin!</h2>
        <p class="text-sm text-gray-600 mt-1">Here's what's happening with your system today.</p>
      </div>
      
      <!-- Stats Overview -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <!-- Active Users -->
        <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-500">Active Users</h3>
            <span class="p-2 bg-blue-100 text-blue-600 rounded-lg">
              <i class="fas fa-user-check"></i>
            </span>
          </div>
          <div class="flex items-baseline">
            <span class="text-2xl font-bold text-gray-800">2,453</span>
            <span class="ml-2 text-xs font-medium text-green-500 flex items-center">
              <i class="fas fa-arrow-up mr-1"></i> 12.5%
            </span>
          </div>
          <div class="text-xs text-gray-500 mt-2">Compared to last month</div>
        </div>
        
        <!-- New Accounts -->
        <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-500">New Accounts</h3>
            <span class="p-2 bg-green-100 text-green-600 rounded-lg">
              <i class="fas fa-user-plus"></i>
            </span>
          </div>
          <div class="flex items-baseline">
            <span class="text-2xl font-bold text-gray-800">128</span>
            <span class="ml-2 text-xs font-medium text-green-500 flex items-center">
              <i class="fas fa-arrow-up mr-1"></i> 8.2%
            </span>
          </div>
          <div class="text-xs text-gray-500 mt-2">New accounts this week</div>
        </div>
        
        <!-- Reports Generated -->
        <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-500">Reports Generated</h3>
            <span class="p-2 bg-purple-100 text-purple-600 rounded-lg">
              <i class="fas fa-file-alt"></i>
            </span>
          </div>
          <div class="flex items-baseline">
            <span class="text-2xl font-bold text-gray-800">1,245</span>
            <span class="ml-2 text-xs font-medium text-red-500 flex items-center">
              <i class="fas fa-arrow-down mr-1"></i> 3.8%
            </span>
          </div>
          <div class="text-xs text-gray-500 mt-2">Reports from last 30 days</div>
        </div>
        
        <!-- System Status -->
        <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-500">System Status</h3>
            <span class="p-2 bg-red-100 text-[#C40F12] rounded-lg">
              <i class="fas fa-server"></i>
            </span>
          </div>
          <div class="flex items-center">
            <span class="h-3 w-3 bg-green-500 rounded-full mr-2"></span>
            <span class="text-base font-semibold text-gray-800">All Systems Operational</span>
          </div>
          <div class="text-xs text-gray-500 mt-2">Last checked 5 minutes ago</div>
        </div>
      </div>
      
      <!-- Dashboard Content -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-lg font-bold text-gray-800">CreditInfo Admin Panel</h2>
          <div>
            <button class="px-4 py-2 bg-[#C40F12] text-white rounded-lg text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors">
              <i class="fas fa-plus mr-2"></i> New Report
            </button>
          </div>
        </div>
        <p class="text-sm text-gray-600 mb-4">Use the sidebar to navigate through different modules. This admin panel allows you to manage users, view statements, generate reports, and configure system settings.</p>
        <div class="p-4 bg-blue-50 rounded-lg border border-blue-100 text-sm text-blue-800">
          <div class="flex items-start">
            <span class="mr-3 text-blue-500">
              <i class="fas fa-info-circle text-lg"></i>
            </span>
            <div>
              <p class="font-medium">Getting Started</p>
              <p class="mt-1">Check the documentation for more information on how to use the CreditInfo admin panel. If you need help, contact our support team.</p>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>


@livewireScripts



</body>
</html>