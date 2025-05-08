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
      // Get all sidebar links
      const sidebarLinks = document.querySelectorAll('.sidebar-link');
      
      // Function to set active styles
      function setActiveStyles(link) {
        // Remove active classes from all links first
        sidebarLinks.forEach(el => {
          el.classList.remove('active');
          
          // Remove Tailwind classes for active state
          el.classList.remove('bg-red-50', 'text-[#C40F12]');
          
          // Reset icon color
          const icon = el.querySelector('span:first-of-type');
          if (icon) {
            icon.classList.remove('text-[#C40F12]');
            icon.classList.add('text-gray-500');
          }
        });
        
        // Add active class to selected link
        link.classList.add('active');
        
        // Add Tailwind classes for active state
        link.classList.add('bg-red-50', 'text-[#C40F12]');
        
        // Update icon color
        const icon = link.querySelector('span:first-of-type');
        if (icon) {
          icon.classList.remove('text-gray-500');
          icon.classList.add('text-[#C40F12]');
        }
        
        // Save in localStorage
        localStorage.setItem('activeMenu', link.getAttribute('data-page'));
        
        // Update header title (if you have this element)
        const pageTitle = document.getElementById('page-title');
        if (pageTitle) {
          pageTitle.innerText = link.querySelector('.link-text').innerText;
        }
      }
      
      // Add click event listeners to all sidebar links
      sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
          // Don't prevent default as we want to navigate to the link
          
          // Set this link as active
          setActiveStyles(this);
          
          // Close sidebar on mobile after navigation
          if (window.innerWidth < 768) {
            toggleSidebar();
          }
        });
      });
      
      // Check if we should restore from localStorage or use route-based active state
      const storedActiveMenu = localStorage.getItem('activeMenu');
      
      if (storedActiveMenu) {
        // If there's a stored active menu, use it
        const storedActiveLink = document.querySelector(`.sidebar-link[data-page="${storedActiveMenu}"]`);
        if (storedActiveLink) {
          setActiveStyles(storedActiveLink);
        } else {
          // Use current route as fallback
          const currentActiveLink = document.querySelector('.sidebar-link.bg-red-50');
          if (currentActiveLink) {
            setActiveStyles(currentActiveLink);
            // Update localStorage with current active route
            localStorage.setItem('activeMenu', currentActiveLink.getAttribute('data-page'));
          }
        }
      } else {
        // No stored menu, use route-based active link
        const currentActiveLink = document.querySelector('.sidebar-link.bg-red-50');
        if (currentActiveLink) {
          setActiveStyles(currentActiveLink);
          // Set in localStorage
          localStorage.setItem('activeMenu', currentActiveLink.getAttribute('data-page'));
        } else {
          // Default to dashboard if nothing else is active
          const dashboardLink = document.querySelector('.sidebar-link[data-page="dashboard"]');
          if (dashboardLink) {
            setActiveStyles(dashboardLink);
          }
        }
      }
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


<script>

document.addEventListener('notify', event => {
    // Show notification with event.detail.type and event.detail.message
    showNotification(event.detail.type, event.detail.message);
});

</script>
</body>
</html>