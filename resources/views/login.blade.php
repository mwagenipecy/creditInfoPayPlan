<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - CreditInfo</title>
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

<!-- Navbar with shadow animation on scroll -->
<div class="sticky top-0 z-40 bg-white transition-shadow duration-300" id="navbar">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex flex-col md:flex-row md:items-center justify-between py-4">
      <div class="flex items-center justify-between w-full md:w-auto">
        <div class="flex items-center space-x-2">
          <div class="bg-red-50 p-1 rounded-lg">
            <svg class="h-6 w-6 text-[#C40F12]" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path>
            </svg>
          </div>
          <span class="text-xl font-bold text-gray-800">Credit<span class="text-[#C40F12]">Info</span></span>
        </div>
        <button class="md:hidden text-gray-700 hover:text-[#C40F12] transition-colors focus:outline-none" id="mobileMenuButton">
          <i class="fas fa-bars text-lg"></i>
        </button>
      </div>
      
      <ul class="hidden md:flex space-x-6 text-gray-700 text-sm font-medium">
        <li><a href="#" class="hover:text-[#C40F12] transition-colors py-2 border-b-2 border-transparent hover:border-[#C40F12] flex items-center">
          <i class="fas fa-chart-line mr-1.5 opacity-70"></i>Services</a></li>
        <li><a href="#" class="hover:text-[#C40F12] transition-colors py-2 border-b-2 border-transparent hover:border-[#C40F12] flex items-center">
          <i class="fas fa-lightbulb mr-1.5 opacity-70"></i>Solutions</a></li>
        <li><a href="#" class="hover:text-[#C40F12] transition-colors py-2 border-b-2 border-transparent hover:border-[#C40F12] flex items-center">
          <i class="fas fa-tag mr-1.5 opacity-70"></i>Pricing</a></li>
        <li><a href="#" class="hover:text-[#C40F12] transition-colors py-2 border-b-2 border-transparent hover:border-[#C40F12] flex items-center">
          <i class="fas fa-building mr-1.5 opacity-70"></i>About Us</a></li>
        <li><a href="#" class="hover:text-[#C40F12] transition-colors py-2 border-b-2 border-transparent hover:border-[#C40F12] flex items-center">
          <i class="fas fa-book mr-1.5 opacity-70"></i>Resources</a></li>
      </ul>
      
      <div class="hidden md:flex space-x-4 items-center">
        <a href="#" class="text-gray-700 hover:text-[#C40F12] transition-colors bg-gray-100 hover:bg-gray-200 p-2 rounded-full">
          <i class="fas fa-search text-sm"></i>
        </a>
        <div class="h-6 mx-2 border-l border-gray-200"></div>
        <a href="#" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-[#C40F12] transition-colors border-b-2 border-transparent hover:border-[#C40F12]">Login</a>
        <a href="#" class="px-4 py-2 text-sm font-medium text-white bg-[#C40F12] rounded-md hover:bg-opacity-90 transition-colors shadow-md btn-hover">Register</a>
      </div>
      
      <!-- Mobile menu -->
      <div class="md:hidden mt-4 hidden fade-in" id="mobileMenu">
        <ul class="flex flex-col space-y-3 text-gray-700 text-sm font-medium mb-4">
          <li><a href="#" class="block hover:text-[#C40F12] flex items-center p-2 rounded-md hover:bg-red-50">
            <i class="fas fa-chart-line w-5 mr-2"></i>Services</a></li>
          <li><a href="#" class="block hover:text-[#C40F12] flex items-center p-2 rounded-md hover:bg-red-50">
            <i class="fas fa-lightbulb w-5 mr-2"></i>Solutions</a></li>
          <li><a href="#" class="block hover:text-[#C40F12] flex items-center p-2 rounded-md hover:bg-red-50">
            <i class="fas fa-tag w-5 mr-2"></i>Pricing</a></li>
          <li><a href="#" class="block hover:text-[#C40F12] flex items-center p-2 rounded-md hover:bg-red-50">
            <i class="fas fa-building w-5 mr-2"></i>About Us</a></li>
          <li><a href="#" class="block hover:text-[#C40F12] flex items-center p-2 rounded-md hover:bg-red-50">
            <i class="fas fa-book w-5 mr-2"></i>Resources</a></li>
        </ul>
        <div class="flex space-x-3">
          <a href="#" class="flex-1 px-4 py-2 text-sm font-medium text-center text-gray-700 border border-gray-300 rounded-md hover:text-[#C40F12] hover:border-[#C40F12] transition-colors">Login</a>
          <a href="#" class="flex-1 px-4 py-2 text-sm font-medium text-center text-white bg-[#C40F12] rounded-md hover:bg-opacity-90 transition-colors shadow-md">Register</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="min-h-screen grid grid-cols-1 md:grid-cols-2">
  
  <!-- Branding Section -->
  <div class="relative hidden md:flex items-center justify-start overflow-hidden bg-white rounded-3xl m-4">
    <!-- Backdrop Shapes -->
    <div class="absolute top-0 right-0 w-64 h-64 rounded-full bg-red-100 opacity-60 blur-3xl"></div>
    <div class="absolute bottom-0 left-20 w-80 h-80 rounded-full bg-red-50 opacity-60 blur-3xl"></div>
    
    <!-- Image with Gradient Overlay -->
    <div class="absolute inset-0 overflow-hidden rounded-3xl">
      <img src="{{ asset('/image.jpg') }}" alt="Background"
        class="absolute inset-0 w-full h-full object-cover z-0 rounded-3xl" />
        
      <!-- Bottom Gradient -->
      <div class="absolute bottom-0 left-0 w-full h-2/3 z-10 pointer-events-none rounded-b-3xl"
        style="background: linear-gradient(to top, rgba(196, 15, 18, 0.9), transparent);"></div>
        
      <!-- Right Gradient -->
      <div class="absolute top-0 right-0 w-1/2 h-full z-10 pointer-events-none rounded-r-3xl"
        style="background: linear-gradient(to left, rgba(196, 15, 18, 0.7), transparent);"></div>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute top-20 right-20 z-20">
      <div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-md rounded-xl p-4 shadow-lg float-animation" style="animation-delay: 0.5s">
        <i class="fas fa-shield-alt text-white text-xl"></i>
      </div>
    </div>
    
    <div class="absolute bottom-32 right-40 z-20">
      <div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-md rounded-xl p-4 shadow-lg float-animation" style="animation-delay: 1s">
        <i class="fas fa-chart-pie text-white text-xl"></i>
      </div>
    </div>
    
    <div class="absolute top-40 left-20 z-20">
      <div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-md rounded-xl p-4 shadow-lg float-animation" style="animation-delay: 1.5s">
        <i class="fas fa-fingerprint text-white text-xl"></i>
      </div>
    </div>

    <!-- Content -->
    <div class="relative z-20 text-white p-10 space-y-6 max-w-lg fade-in">
      <div class="inline-flex items-center space-x-2 bg-white bg-opacity-10 backdrop-filter backdrop-blur-md px-4 py-2 rounded-full">
        <div class="h-2 w-2 bg-green-400 rounded-full"></div>
        <span class="text-sm font-medium">Trusted by 10,000+ institutions</span>
      </div>
      
      <h1 class="text-5xl font-bold leading-tight">Welcome Back!</h1>
      <p class="text-xl opacity-90">Access your financial insights with a secure and streamlined experience.</p>
      
      <div class="flex items-center space-x-6 pt-4">
        <div class="flex items-center space-x-2">
          <div class="h-10 w-10 rounded-full bg-white flex items-center justify-center">
            <i class="fas fa-lock text-[#C40F12]"></i>
          </div>
          <div>
            <p class="text-sm font-semibold">Secure Access</p>
            <p class="text-xs opacity-80">256-bit encryption</p>
          </div>
        </div>
        
        <div class="flex items-center space-x-2">
          <div class="h-10 w-10 rounded-full bg-white flex items-center justify-center">
            <i class="fas fa-bolt text-[#C40F12]"></i>
          </div>
          <div>
            <p class="text-sm font-semibold">Fast Experience</p>
            <p class="text-xs opacity-80">Optimized performance</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Login Form -->
  <div class="flex items-center justify-center min-h-screen bg-white p-6 md:p-12">
    <div class="w-full max-w-md space-y-8 fade-in">
      <div class="text-center mb-10">
        <div class="inline-block p-3 rounded-full bg-red-50 mb-4">
          <svg class="h-8 w-8 text-[#C40F12]" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path>
          </svg>
        </div>
        <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
        <p class="text-sm text-gray-500 mt-2">Enter your credentials to access your account</p>
      </div>

      <div class="bg-white rounded-xl p-8 card-shadow">
        <form action="#" method="POST" class="space-y-5">
          <!-- Email Field -->
          <div class="gradient-border">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <div class="relative">
              <input
                type="email"
                name="email"
                id="email"
                required
                placeholder="you@example.com"
                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-md placeholder-gray-400 bg-gray-50 transition-all duration-300 ease-in-out focus:outline-none focus:border-[#C40F12] focus:bg-white input-with-icon"
              />
              <div class="input-icon left-3">
                <i class="fas fa-envelope"></i>
              </div>
            </div>
          </div>

          <!-- Password Field -->
          <div class="gradient-border">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <div class="relative">
              <input
                type="password"
                name="password"
                id="password"
                required
                placeholder="••••••••"
                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-md placeholder-gray-400 bg-gray-50 transition-all duration-300 ease-in-out focus:outline-none focus:border-[#C40F12] focus:bg-white input-with-icon"
              />
              <div class="input-icon left-3">
                <i class="fas fa-lock"></i>
              </div>
            </div>
          </div>

          <!-- Remember Me & Forgot -->
          <div class="flex items-center justify-between text-sm pt-2">
            <label class="flex items-center text-gray-600 hover:text-gray-800 cursor-pointer">
              <input type="checkbox" class="text-[#C40F12] focus:ring-[#C40F12] rounded border-gray-300 h-4 w-4" />
              <span class="ml-2">Remember me</span>
            </label>
            <a href="#" class="text-[#C40F12] hover:text-red-700 font-medium transition">Forgot password?</a>
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            class="w-full py-3 px-4 mt-6 bg-[#C40F12] text-white font-semibold rounded-md shadow-md hover:bg-red-700 transition duration-300 ease-in-out flex items-center justify-center btn-hover"
          >
            <i class="fas fa-sign-in-alt mr-2"></i>
            Log In
          </button>
        </form>
        
        <!-- Social Login -->
        <div class="mt-6">
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-4 bg-white text-gray-500">Or continue with</span>
            </div>
          </div>
          
          <div class="mt-6 grid grid-cols-2 gap-3">
            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-200 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
              <i class="fab fa-google text-red-500"></i>
            </a>
            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-200 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
              <i class="fab fa-microsoft text-blue-500"></i>
            </a>
          </div>
        </div>
      </div>

      <div class="text-center text-sm text-gray-500 mt-6">
        Don't have an account?
        <a href="#" class="text-[#C40F12] font-semibold hover:text-red-700 transition">Create an account</a>
      </div>
    </div>
  </div>
</div>

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