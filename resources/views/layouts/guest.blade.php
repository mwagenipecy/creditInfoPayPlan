<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - CreditInfo</title>

      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Security Headers -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="X-XSS-Protection" content="1; mode=block">
    <meta http-equiv="Referrer-Policy" content="strict-origin-when-cross-origin">
    
    <!-- Content Security Policy -->
    <!-- <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; img-src 'self' data: https:;"> -->
  <link rel="icon" href="{{ asset('/logo/cit-logo.png') }}" type="image/x-icon" />
  <link rel="apple-touch-icon" href="{{ asset('/logo/cit-logo.png') }}" />


  

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    body {
      font-family: 'Poppins', sans-serif;
    }
    
    .float-animation {
      animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
      0%   { transform: translateY(0px); }
      50%  { transform: translateY(-15px); }
      100% { transform: translateY(0px); }
    }

    .gradient-bg {
      background: linear-gradient(135deg, #C40F12 0%, #ff4b4e 100%);
    }

    @keyframes spinRing {
      to { transform: rotate(360deg); }
    }

    .animate-spin-dot {
      animation: spinRing 2s linear infinite;
      transform-origin: center 48px;
    }

    .animate-spin-dot:nth-child(1) { transform: rotate(calc(0 * 45deg)) translateY(-48px); }
    .animate-spin-dot:nth-child(2) { transform: rotate(calc(1 * 45deg)) translateY(-48px); }
    .animate-spin-dot:nth-child(3) { transform: rotate(calc(2 * 45deg)) translateY(-48px); }
    .animate-spin-dot:nth-child(4) { transform: rotate(calc(3 * 45deg)) translateY(-48px); }
    .animate-spin-dot:nth-child(5) { transform: rotate(calc(4 * 45deg)) translateY(-48px); }
    .animate-spin-dot:nth-child(6) { transform: rotate(calc(5 * 45deg)) translateY(-48px); }
    .animate-spin-dot:nth-child(7) { transform: rotate(calc(6 * 45deg)) translateY(-48px); }
    .animate-spin-dot:nth-child(8) { transform: rotate(calc(7 * 45deg)) translateY(-48px); }

    .focus\:shadow-red:focus {
      box-shadow: 0 0 0 3px rgba(196, 15, 18, 0.3);
    }

    .animate-input:focus {
      animation: glow 0.3s ease-in-out forwards;
    }

    @keyframes glow {
      0% {
        box-shadow: 0 0 0 0 rgba(196, 15, 18, 0.4);
      }
      100% {
        box-shadow: 0 0 0 4px rgba(196, 15, 18, 0.2);
      }
    }
    
    .input-icon {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      color: #9ca3af;
      pointer-events: none;
      transition: all 0.3s;
    }
    
    .input-with-icon:focus + .input-icon {
      color: #C40F12;
    }
    
    .fade-in {
      animation: fadeIn 0.5s ease-in-out forwards;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .btn-hover {
      position: relative;
      overflow: hidden;
      z-index: 1;
    }
    
    .btn-hover:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.2);
      transform: scaleX(0);
      transform-origin: right;
      transition: transform 0.5s ease-in-out;
      z-index: -1;
    }
    
    .btn-hover:hover:after {
      transform: scaleX(1);
      transform-origin: left;
    }
    
    .card-shadow {
      box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.1), 0 2px 10px -2px rgba(0, 0, 0, 0.05);
    }
    
    .gradient-border {
      position: relative;
      border-radius: 0.5rem;
      background: white;
    }
    
    .gradient-border::after {
      content: '';
      position: absolute;
      top: -2px;
      left: -2px;
      right: -2px;
      bottom: -2px;
      background: linear-gradient(45deg, #C40F12, #ff4b4e, #C40F12);
      border-radius: 0.6rem;
      z-index: -1;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    
    .gradient-border:focus-within::after {
      opacity: 1;
    }
  </style>


   <!-- Scripts -->
   @vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Styles -->
@livewireStyles



</head>
<body class="bg-gray-50">

<!-- Custom Page Loader -->
<div id="page-loader" class="fixed inset-0 bg-white flex items-center justify-center z-50">
  <div class="relative w-24 h-24">
    <!-- Rotating Dots -->
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-3 h-3 bg-gray-400 rounded-full animate-spin-dot opacity-80" style="--i: 0;"></div>
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-3 h-3 bg-gray-400 rounded-full animate-spin-dot opacity-70" style="--i: 1;"></div>
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-3 h-3 bg-gray-400 rounded-full animate-spin-dot opacity-60" style="--i: 2;"></div>
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-3 h-3 bg-gray-400 rounded-full animate-spin-dot opacity-50" style="--i: 3;"></div>
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-3 h-3 bg-gray-400 rounded-full animate-spin-dot opacity-40" style="--i: 4;"></div>
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-3 h-3 bg-gray-400 rounded-full animate-spin-dot opacity-30" style="--i: 5;"></div>
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-3 h-3 bg-gray-400 rounded-full animate-spin-dot opacity-20" style="--i: 6;"></div>
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-3 h-3 bg-gray-400 rounded-full animate-spin-dot opacity-10" style="--i: 7;"></div>

    <!-- Red "i" in the middle -->
    <div class="absolute inset-0 flex items-center justify-center">
      <div class="text-[#C40F12] font-bold text-4xl leading-none">i</div>
    </div>
  </div>
</div>


 <livewire:component.nav-bar />


 @yield('guest-section')

@livewireScripts



<script>
  // Page loader
  window.addEventListener('load', () => {
    const loader = document.getElementById('page-loader');
    if (loader) {
      setTimeout(() => {
        loader.style.opacity = '0';
        setTimeout(() => {
          loader.style.display = 'none';
        }, 300);
      }, 500);
    }
  });
  
  // Mobile menu toggle
  document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    
    menuButton.addEventListener('click', function() {
      mobileMenu.classList.toggle('hidden');
    });
    
    // Add shadow to navbar on scroll
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', function() {
      if (window.scrollY > 10) {
        navbar.classList.add('shadow-md');
      } else {
        navbar.classList.remove('shadow-md');
      }
    });
  });
</script>
</body>
</html>