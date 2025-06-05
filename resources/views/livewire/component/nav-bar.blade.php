<div>


<div class="sticky top-0 z-40 bg-white shadow-md" id="navbar">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex flex-col md:flex-row md:items-center justify-between py-4">
        <div class="flex items-center justify-between w-full md:w-auto">
          <div class="flex items-center space-x-2">
            <div class="bg-red-50 p-1 rounded-lg">
              <!-- <svg class="h-6 w-6 text-[#C40F12]" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path>
              </svg> -->
            </div>
            <a href="{{ route('home') }}">

            <img src="{{ asset('/creditInfoLogo.svg') }}" alt="InfoSec Company Logo" class="h-8" />

            </a>
            </div>
          <button class="md:hidden text-gray-700 hover:text-[#C40F12] transition-colors focus:outline-none" id="mobileMenuButton">
            <i class="fas fa-bars text-lg"></i>
          </button>
        </div>
        
        <ul class="hidden md:flex space-x-6 text-gray-700 text-sm font-medium">
  <li>
    <a href="{{ route('home') }}#services" 
       class="hover:text-[#C40F12] transition-colors py-2 border-b-2 border-transparent hover:border-[#C40F12] flex items-center {{ request()->is('*#services') ? 'text-[#C40F12] border-[#C40F12]' : '' }}">
      <i class="fas fa-chart-line mr-1.5 opacity-70"></i>Services
    </a>
  </li>
  <li>
    <a href="{{ route('home') }}#features" 
       class="hover:text-[#C40F12] transition-colors py-2 border-b-2 border-transparent hover:border-[#C40F12] flex items-center {{ request()->is('*#features') ? 'text-[#C40F12] border-[#C40F12]' : '' }}">
      <i class="fas fa-lightbulb mr-1.5 opacity-70"></i>Features
    </a>
  </li>
  <li>
    <a href="{{ route('price.list') }}" 
       class="hover:text-[#C40F12] transition-colors py-2 border-b-2 border-transparent hover:border-[#C40F12] flex items-center {{ request()->routeIs('price.list') ? 'text-[#C40F12] border-[#C40F12]' : '' }}">
      <i class="fas fa-tag mr-1.5 opacity-70"></i>Pricing
    </a>
  </li>
  <!-- <li><a href="#testimonials" class="hover:text-[#C40F12] transition-colors py-2 border-b-2 border-transparent hover:border-[#C40F12] flex items-center">
  <i class="fas fa-comment mr-1.5 opacity-70"></i>Testimonials</a></li> -->
  <li>
    <a href="https://tz.creditinfo.com/" 
       class="hover:text-[#C40F12] transition-colors py-2 border-b-2 border-transparent hover:border-[#C40F12] flex items-center {{ request()->is('*#about') ? 'text-[#C40F12] border-[#C40F12]' : '' }}">
      <i class="fas fa-building mr-1.5 opacity-70"></i>About Us
    </a>
  </li>
</ul>
        
        <div class="hidden md:flex space-x-4 items-center">
          <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-[#C40F12] transition-colors border-b-2 border-transparent hover:border-[#C40F12]">Login</a>
          <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-[#C40F12] rounded-md hover:bg-opacity-90 transition-colors shadow-md btn-hover">Register</a>
        </div>
        
        <!-- Mobile menu -->
        <div class="md:hidden mt-4 hidden fade-in" id="mobileMenu">
          <ul class="flex flex-col space-y-3 text-gray-700 text-sm font-medium mb-4">
            <li><a href="{{ route('home') }}#services" class="block hover:text-[#C40F12] flex items-center p-2 rounded-md hover:bg-red-50">
              <i class="fas fa-chart-line w-5 mr-2"></i>Services</a></li>
            <li><a href="{{ route('home') }}#features" class="block hover:text-[#C40F12] flex items-center p-2 rounded-md hover:bg-red-50">
              <i class="fas fa-lightbulb w-5 mr-2"></i>Features</a></li>
            <li><a href="{{ route('price.list') }}" class="block hover:text-[#C40F12] flex items-center p-2 rounded-md hover:bg-red-50">
              <i class="fas fa-tag w-5 mr-2"></i>Pricing</a></li>
          
            <li><a href="https://tz.creditinfo.com/" class="block hover:text-[#C40F12] flex items-center p-2 rounded-md hover:bg-red-50">
              <i class="fas fa-building w-5 mr-2"></i>About Us</a></li>
          </ul>
          <div class="flex space-x-3">
            <a href="{{ route('login') }}" class="flex-1 px-4 py-2 text-sm font-medium text-center text-gray-700 border border-gray-300 rounded-md hover:text-[#C40F12] hover:border-[#C40F12] transition-colors">Login</a>
            <a href="{{ route('register') }}" class="flex-1 px-4 py-2 text-sm font-medium text-center text-white bg-[#C40F12] rounded-md hover:bg-opacity-90 transition-colors shadow-md">Register</a>
          </div>
        </div>
      </div>
    </div>
  </div>


  

</div>
