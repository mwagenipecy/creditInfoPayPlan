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
        //   e.preventDefault();
          
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
 <livewire:side-bar />

  <!-- Main content -->
  <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">

   <livewire:header/>

    <!-- Page Content Area -->
    <main class="flex-1 p-6 lg:p-8 bg-gray-50">


     @yield('main-section')
    


    </main>

    
  </div>
</div>


@livewireScripts



</body>
</html>