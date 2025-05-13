<x-guest-layout>
    <x-authentication-card>
     

  @section('guest-section')

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
        <!-- <div class="inline-block p-3 rounded-full bg-red-50 mb-4">
          <svg class="h-8 w-8 text-[#C40F12]" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path>
          </svg>
        </div> -->
        <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
        <p class="text-sm text-gray-500 mt-2">Enter your credentials to access your account</p>
      </div>

      <div class="bg-white rounded-xl p-8 card-shadow">
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
          @csrf

          <x-validation-errors class="mb-4" />

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
            <a href="{{ route('login.google') }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-200 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
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
        <a href="{{ route('register') }}" class="text-[#C40F12] font-semibold hover:text-red-700 transition">Create an account</a>
      </div>
    </div>
  </div>
</div>
  
  @endsection


    </x-authentication-card>
</x-guest-layout>
