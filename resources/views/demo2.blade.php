<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CreditInfo - Financial Statement Processing Solutions</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    body {
      font-family: 'Poppins', sans-serif;
      scroll-behavior: smooth;
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

    .feature-card:hover {
      transform: translateY(-5px);
      transition: all 0.3s ease;
    }

    .testimonial-slider {
      scroll-behavior: smooth;
      scroll-snap-type: x mandatory;
    }

    .testimonial-slide {
      scroll-snap-align: center;
    }
  </style>
</head>

<body class="bg-gray-50">
  <!-- Top promo bar -->
  <div class="bg-[#C40F12] text-white text-center text-sm py-2">
    Limited time offer: 20% OFF all statement packages with code CREDIT20
  </div>

  <!-- Navbar -->
  <div class="sticky top-0 z-40 bg-white shadow-md" id="navbar">
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
          <li><a href="#services" class="hover:text-[#C40F12] transition-colors py-2 border-b-2 border-transparent hover:border-[#C40F12] flex items-center">
            <i class="fas fa-chart-line mr-1.5 opacity-70"></i>Services</a></li>
          <li><a href="#features" class="hover:text-[#C40F12] transition-colors py-2 border-b-2 border-transparent hover:border-[#C40F12] flex items-center">
            <i class="fas fa-lightbulb mr-1.5 opacity-70"></i>Features</a></li>
          <li><a href="#pricing" class="hover:text-[#C40F12] transition-colors py-2 border-b-2 border-transparent hover:border-[#C40F12] flex items-center">
            <i class="fas fa-tag mr-1.5 opacity-70"></i>Pricing</a></li>
          <li><a href="#testimonials" class="hover:text-[#C40F12] transition-colors py-2 border-b-2 border-transparent hover:border-[#C40F12] flex items-center">
            <i class="fas fa-comment mr-1.5 opacity-70"></i>Testimonials</a></li>
          <li><a href="#about" class="hover:text-[#C40F12] transition-colors py-2 border-b-2 border-transparent hover:border-[#C40F12] flex items-center">
            <i class="fas fa-building mr-1.5 opacity-70"></i>About Us</a></li>
        </ul>
        
        <div class="hidden md:flex space-x-4 items-center">
          <a href="#" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-[#C40F12] transition-colors border-b-2 border-transparent hover:border-[#C40F12]">Login</a>
          <a href="#" class="px-4 py-2 text-sm font-medium text-white bg-[#C40F12] rounded-md hover:bg-opacity-90 transition-colors shadow-md btn-hover">Register</a>
        </div>
        
        <!-- Mobile menu -->
        <div class="md:hidden mt-4 hidden fade-in" id="mobileMenu">
          <ul class="flex flex-col space-y-3 text-gray-700 text-sm font-medium mb-4">
            <li><a href="#services" class="block hover:text-[#C40F12] flex items-center p-2 rounded-md hover:bg-red-50">
              <i class="fas fa-chart-line w-5 mr-2"></i>Services</a></li>
            <li><a href="#features" class="block hover:text-[#C40F12] flex items-center p-2 rounded-md hover:bg-red-50">
              <i class="fas fa-lightbulb w-5 mr-2"></i>Features</a></li>
            <li><a href="#pricing" class="block hover:text-[#C40F12] flex items-center p-2 rounded-md hover:bg-red-50">
              <i class="fas fa-tag w-5 mr-2"></i>Pricing</a></li>
            <li><a href="#testimonials" class="block hover:text-[#C40F12] flex items-center p-2 rounded-md hover:bg-red-50">
              <i class="fas fa-comment w-5 mr-2"></i>Testimonials</a></li>
            <li><a href="#about" class="block hover:text-[#C40F12] flex items-center p-2 rounded-md hover:bg-red-50">
              <i class="fas fa-building w-5 mr-2"></i>About Us</a></li>
          </ul>
          <div class="flex space-x-3">
            <a href="#" class="flex-1 px-4 py-2 text-sm font-medium text-center text-gray-700 border border-gray-300 rounded-md hover:text-[#C40F12] hover:border-[#C40F12] transition-colors">Login</a>
            <a href="#" class="flex-1 px-4 py-2 text-sm font-medium text-center text-white bg-[#C40F12] rounded-md hover:bg-opacity-90 transition-colors shadow-md">Register</a>
          </div>
        </div>
      </div>
    </div>
  </div>

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
                  <a href="#pricing" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#C40F12] hover:bg-red-700 md:py-4 md:text-lg md:px-10 btn-hover">
                    View Pricing
                  </a>
                </div>
                <div class="mt-3 sm:mt-0 sm:ml-3">
                  <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-[#C40F12] bg-white border-[#C40F12] hover:bg-red-50 md:py-4 md:text-lg md:px-10">
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

  <!-- Trusted By Section -->
  <div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center">
        <h2 class="text-base font-semibold text-[#C40F12] tracking-wide uppercase">Trusted By</h2>
        <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
          Leading Financial Institutions
        </p>
      </div>
      
      <div class="mt-10 grid grid-cols-2 gap-8 md:grid-cols-6 lg:grid-cols-6">
        <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
          <div class="h-12 grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
            <img src="/api/placeholder/120/48" alt="Client Logo" class="h-full">
          </div>
        </div>
        <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
          <div class="h-12 grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
            <img src="/api/placeholder/120/48" alt="Client Logo" class="h-full">
          </div>
        </div>
        <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
          <div class="h-12 grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
            <img src="/api/placeholder/120/48" alt="Client Logo" class="h-full">
          </div>
        </div>
        <div class="col-span-1 flex justify-center md:col-span-3 lg:col-span-1">
          <div class="h-12 grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
            <img src="/api/placeholder/120/48" alt="Client Logo" class="h-full">
          </div>
        </div>
        <div class="col-span-2 flex justify-center md:col-span-3 lg:col-span-1">
          <div class="h-12 grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
            <img src="/api/placeholder/120/48" alt="Client Logo" class="h-full">
          </div>
        </div>
        <div class="col-span-2 flex justify-center md:col-span-3 lg:col-span-1">
          <div class="h-12 grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
            <img src="/api/placeholder/120/48" alt="Client Logo" class="h-full">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Services Section -->
  <section id="services" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center">
        <h2 class="text-base font-semibold text-[#C40F12] tracking-wide uppercase">Our Services</h2>
        <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
          Comprehensive Statement Solutions
        </p>
        <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
          Everything you need to process, manage, and analyze financial statements efficiently.
        </p>
      </div>

      <div class="mt-16 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
        <!-- Service 1 -->
        <div class="relative bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 feature-card">
          <div class="p-6">
            <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center mb-5">
              <i class="fas fa-file-invoice text-[#C40F12] text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Statement Processing</h3>
            <p class="text-gray-600">
              Convert raw financial data into formatted statements with our advanced processing engine.
            </p>
            <ul class="mt-4 space-y-2">
              <li class="flex items-center text-sm text-gray-500">
                <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Multi-format support
              </li>
              <li class="flex items-center text-sm text-gray-500">
                <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Transaction categorization
              </li>
              <li class="flex items-center text-sm text-gray-500">
                <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Real-time processing
              </li>
            </ul>
            <a href="#" class="inline-flex items-center mt-5 text-sm font-medium text-[#C40F12]">
              Learn more 
              <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </div>

        <!-- Service 2 -->
        <div class="relative bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 feature-card">
          <div class="p-6">
            <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center mb-5">
              <i class="fas fa-chart-bar text-[#C40F12] text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Financial Analysis</h3>
            <p class="text-gray-600">
              Extract valuable insights from statement data with our powerful analytical tools.
            </p>
            <ul class="mt-4 space-y-2">
              <li class="flex items-center text-sm text-gray-500">
                <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Trend identification
              </li>
              <li class="flex items-center text-sm text-gray-500">
                <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Income validation
              </li>
              <li class="flex items-center text-sm text-gray-500">
                <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Custom reporting
              </li>
            </ul>
            <a href="#" class="inline-flex items-center mt-5 text-sm font-medium text-[#C40F12]">
              Learn more 
              <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </div>

        <!-- Service 3 -->
        <div class="relative bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 feature-card">
          <div class="p-6">
            <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center mb-5">
              <i class="fas fa-code text-[#C40F12] text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">API Integration</h3>
            <p class="text-gray-600">
              Seamlessly connect CreditInfo with your existing systems through our robust API.
            </p>
            <ul class="mt-4 space-y-2">
              <li class="flex items-center text-sm text-gray-500">
                <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                RESTful architecture
              </li>
              <li class="flex items-center text-sm text-gray-500">
                <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Webhooks support
              </li>
              <li class="flex items-center text-sm text-gray-500">
                <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Comprehensive documentation
              </li>
            </ul>
            <a href="#" class="inline-flex items-center mt-5 text-sm font-medium text-[#C40F12]">
              Learn more 
              <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center">
        <h2 class="text-base font-semibold text-[#C40F12] tracking-wide uppercase">Key Features</h2>
        <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
          Why Choose CreditInfo
        </p>
        <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
          Our platform offers everything you need to streamline your financial statement processing.
        </p>
      </div>

      <div class="mt-16">
        <div class="lg:flex lg:items-center lg:space-x-8">
          <div class="lg:w-1/2">
            <div class="aspect-w-16 aspect-h-9 rounded-2xl overflow-hidden">
              <img src="/api/placeholder/600/400" alt="Platform features" class="w-full h-full object-cover rounded-xl">
            </div>
          </div>
          
          <div class="mt-8 lg:mt-0 lg:w-1/2">
            <div class="space-y-8">
              <div class="flex">
                <div class="flex-shrink-0">
                  <div class="flex items-center justify-center h-12 w-12 rounded-md bg-red-50 text-[#C40F12]">
                    <i class="fas fa-shield-alt text-xl"></i>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-medium text-gray-900">Enterprise-Grade Security</h3>
                  <p class="mt-2 text-base text-gray-500">
                    Bank-level encryption, multi-factor authentication, and regular security audits keep your data protected.
                  </p>
                </div>
              </div>
              
              <div class="flex">
                <div class="flex-shrink-0">
                  <div class="flex items-center justify-center h-12 w-12 rounded-md bg-red-50 text-[#C40F12]">
                    <i class="fas fa-bolt text-xl"></i>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-medium text-gray-900">Lightning-Fast Processing</h3>
                  <p class="mt-2 text-base text-gray-500">
                    Process financial statements in real-time with our optimized and scalable infrastructure.
                  </p>
                </div>
              </div>
              
              <div class="flex">
                <div class="flex-shrink-0">
                  <div class="flex items-center justify-center h-12 w-12 rounded-md bg-red-50 text-[#C40F12]">
                    <i class="fas fa-chart-line text-xl"></i>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-medium text-gray-900">Advanced Analytics</h3>
                  <p class="mt-2 text-base text-gray-500">
                    Gain actionable insights with our powerful analytics tools and customizable reports.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


<!-- Footer Section -->
<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- About Us -->
            <div>
                <h3 class="text-lg font-bold mb-4">About CreditInfo</h3>
                <p class="text-sm text-gray-400">
                    CreditInfo is a leading provider of financial statement processing solutions, trusted by institutions worldwide.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="#services" class="text-sm text-gray-400 hover:text-white">Services</a></li>
                    <li><a href="#features" class="text-sm text-gray-400 hover:text-white">Features</a></li>
                    <li><a href="#pricing" class="text-sm text-gray-400 hover:text-white">Pricing</a></li>
                    <li><a href="#testimonials" class="text-sm text-gray-400 hover:text-white">Testimonials</a></li>
                    <li><a href="#about" class="text-sm text-gray-400 hover:text-white">About Us</a></li>
                </ul>
            </div>

            <!-- Contact Us -->
            <div>
                <h3 class="text-lg font-bold mb-4">Contact Us</h3>
                <ul class="space-y-2">
                    <li class="text-sm text-gray-400">
                        <i class="fas fa-envelope mr-2"></i> support@creditinfo.com
                    </li>
                    <li class="text-sm text-gray-400">
                        <i class="fas fa-phone mr-2"></i> +1 (800) 123-4567
                    </li>
                    <li class="text-sm text-gray-400">
                        <i class="fas fa-map-marker-alt mr-2"></i> 123 Financial St, New York, NY
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-8 border-t border-gray-700 pt-8 text-center">
            <p class="text-sm text-gray-400">
                &copy; 2023 CreditInfo. All rights reserved.
            </p>
            <div class="mt-4 flex justify-center space-x-4">
                <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</footer>



<!-- Chatbot Widget -->
<div class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
  <!-- Chat Window (Hidden by default) -->
  <div id="chatWindow" class="hidden mb-4 w-80 bg-white rounded-lg shadow-xl overflow-hidden card-shadow fade-in">
    <!-- Chat Header -->
    <div class="gradient-bg p-4 text-white flex justify-between items-center">
      <div class="flex items-center space-x-2">
        <div class="bg-white bg-opacity-20 p-1 rounded-full">
          <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path>
          </svg>
        </div>
        <span class="font-medium">CreditInfo Assistant</span>
      </div>
      <button id="closeChat" class="text-white hover:text-gray-200 focus:outline-none">
        <i class="fas fa-times"></i>
      </button>
    </div>
    
    <!-- Chat Messages -->
    <div id="chatMessages" class="p-4 h-64 overflow-y-auto bg-gray-50">
      <div class="mb-3">
        <div class="bg-gray-200 text-gray-800 p-2 rounded-lg inline-block max-w-xs">
          <p class="text-sm">Hi there! How can I help you with financial statement processing today?</p>
        </div>
      </div>
    </div>
    
    <!-- Chat Input -->
    <div class="p-3 border-t border-gray-200 bg-white">
      <div class="flex items-center">
        <input type="text" id="chatInput" placeholder="Type your question here..." 
               class="flex-grow px-3 py-2 text-sm bg-gray-100 rounded-l-lg focus:outline-none focus:ring-1 focus:ring-[#C40F12]">
        <button id="sendMessage" class="gradient-bg text-white px-4 py-2 rounded-r-lg btn-hover flex items-center justify-center">
          <i class="fas fa-paper-plane"></i>
        </button>
      </div>
    </div>
  </div>
  
  <!-- Chat Button -->
  <button id="chatButton" class="gradient-bg text-white p-4 rounded-full shadow-lg hover:shadow-xl transition-all focus:outline-none btn-hover">
    <i class="fas fa-comment-dots text-xl"></i>
  </button>
</div>

<script>
  // Chat functionality
  document.addEventListener('DOMContentLoaded', function() {
    const chatButton = document.getElementById('chatButton');
    const chatWindow = document.getElementById('chatWindow');
    const closeChat = document.getElementById('closeChat');
    const chatInput = document.getElementById('chatInput');
    const sendMessage = document.getElementById('sendMessage');
    const chatMessages = document.getElementById('chatMessages');
    
    // Toggle chat window
    chatButton.addEventListener('click', function() {
      chatWindow.classList.toggle('hidden');
      if (!chatWindow.classList.contains('hidden')) {
        chatInput.focus();
      }
    });
    
    // Close chat window
    closeChat.addEventListener('click', function() {
      chatWindow.classList.add('hidden');
    });
    
    // Send message function
    function sendUserMessage() {
      const message = chatInput.value.trim();
      if (message) {
        // Add user message
        const userDiv = document.createElement('div');
        userDiv.className = 'mb-3 text-right';
        userDiv.innerHTML = `
          <div class="bg-[#C40F12] text-white p-2 rounded-lg inline-block max-w-xs">
            <p class="text-sm">${message}</p>
          </div>
        `;
        chatMessages.appendChild(userDiv);
        
        // Clear input
        chatInput.value = '';
        
        // Simulate response (in real implementation, you'd call your API)
        setTimeout(() => {
          const botDiv = document.createElement('div');
          botDiv.className = 'mb-3';
          botDiv.innerHTML = `
            <div class="bg-gray-200 text-gray-800 p-2 rounded-lg inline-block max-w-xs">
              <p class="text-sm">Thanks for your question. Our team will process your inquiry about "${message}" shortly.</p>
            </div>
          `;
          chatMessages.appendChild(botDiv);
          chatMessages.scrollTop = chatMessages.scrollHeight;
        }, 1000);
        
        // Scroll to bottom
        chatMessages.scrollTop = chatMessages.scrollHeight;
      }
    }
    
    // Send on click
    sendMessage.addEventListener('click', sendUserMessage);
    
    // Send on Enter key
    chatInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        sendUserMessage();
      }
    });
  });
</script>





<script>
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
</body>
</html>