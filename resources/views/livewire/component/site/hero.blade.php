<div>
  <!-- Hero Section -->
  <div class="relative bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
      <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:pb-28 xl:pb-32">
        <div class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="sm:text-center lg:text-left fade-in">
              <div class="inline-flex items-center space-x-2 bg-red-50 px-4 py-2 rounded-full mb-4">
                <div class="h-2 w-2 bg-green-400 rounded-full"></div>
                <span class="text-sm font-medium text-gray-700">Trusted by 10,000+ financial institutions</span>
              </div>
              <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                <span class="block xl:inline">Streamline Your</span>
                <span class="block text-[#C40F12] xl:inline"> Statement Processing</span>
              </h1>
              <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                CreditInfo provides financial institutions with efficient, secure, and cost-effective statement processing solutions tailored to your specific needs.
              </p>
              <div class="mt-8 sm:flex sm:justify-center lg:justify-start">
                <div class="rounded-md shadow">
                  <a href="{{ route('price.list') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#C40F12] hover:bg-red-700 md:py-4 md:text-lg md:px-10 btn-hover">
                    View Pricing
                  </a>
                </div>
                <div class="mt-3 sm:mt-0 sm:ml-3">
                  <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-[#C40F12] bg-white border-[#C40F12] hover:bg-red-50 md:py-4 md:text-lg md:px-10">
                    Get Started
                  </a>
                </div>
              </div>
              
              <div class="mt-8 grid grid-cols-3 gap-4">
                <div class="flex items-center space-x-2">
                  <div class="h-10 w-10 rounded-full bg-red-50 flex items-center justify-center">
                    <i class="fas fa-lock text-[#C40F12]"></i>
                  </div>
                  <div>
                    <p class="text-sm font-semibold">Secure</p>
                    <p class="text-xs text-gray-500">256-bit SSL</p>
                  </div>
                </div>
                
                <div class="flex items-center space-x-2">
                  <div class="h-10 w-10 rounded-full bg-red-50 flex items-center justify-center">
                    <i class="fas fa-bolt text-[#C40F12]"></i>
                  </div>
                  <div>
                    <p class="text-sm font-semibold">Fast</p>
                    <p class="text-xs text-gray-500">Real-time processing</p>
                  </div>
                </div>
                
                <div class="flex items-center space-x-2">
                  <div class="h-10 w-10 rounded-full bg-red-50 flex items-center justify-center">
                    <i class="fas fa-chart-line text-[#C40F12]"></i>
                  </div>
                  <div>
                    <p class="text-sm font-semibold">Scalable</p>
                    <p class="text-xs text-gray-500">Grow with you</p>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="relative mt-8 md:mt-0 fade-in" style="animation-delay: 0.3s">
              <!-- Background Shapes -->
              <div class="absolute -top-10 -right-10 w-64 h-64 rounded-full bg-red-100 opacity-60 blur-3xl"></div>
              <div class="absolute -bottom-10 -left-10 w-64 h-64 rounded-full bg-red-50 opacity-60 blur-3xl"></div>
              
              <!-- Image with shadow -->
              <div class="relative z-10 bg-white rounded-2xl overflow-hidden card-shadow">
                <img src="{{ asset('/image.png') }}" alt="Dashboard Preview" class="w-full h-full object-cover" />
                
                <!-- Floating Elements -->
                <div class="absolute top-10 right-10">
                  <div class="bg-white bg-opacity-90 backdrop-filter backdrop-blur-md rounded-xl p-4 shadow-lg float-animation" style="animation-delay: 0.5s">
                    <i class="fas fa-shield-alt text-[#C40F12] text-xl"></i>
                  </div>
                </div>
                
                <div class="absolute bottom-10 left-10">
                  <div class="bg-white bg-opacity-90 backdrop-filter backdrop-blur-md rounded-xl p-4 shadow-lg float-animation" style="animation-delay: 1s">
                    <i class="fas fa-chart-pie text-[#C40F12] text-xl"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
