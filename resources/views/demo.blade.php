<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>InfoSec Protection Plans | Premium Cybersecurity Solutions</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
      
    <!-- Top promo bar -->
    <div class="bg-gradient-to-r from-[#C40F12] to-[#FF4447] text-white text-center text-sm py-3 px-4 relative overflow-hidden">
        <div class="relative z-10">
            <span class="font-semibold">Limited Time Offer:</span> Save 20% on all security packages with code <span class="bg-white bg-opacity-20 px-2 py-1 rounded font-mono font-bold">SECURE20</span>
        </div>
        <div class="absolute top-0 right-0 opacity-10">
            <i class="fas fa-shield-alt text-8xl"></i>
        </div>
    </div>

    <!-- Navbar -->
    <div class="sticky top-0 z-50 bg-white shadow-sm">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between px-4 md:px-6 py-4">
                <div class="flex items-center">
                    <div class="text-xl font-bold text-[#C40F12] mr-8">
                        <img src="{{ asset('/creditInfoLogo.svg') }}" alt="InfoSec Company Logo" class="h-8" />
                    </div>
                    
                    <ul class="hidden lg:flex space-x-8 text-gray-700 text-sm font-medium">
                        <li><a href="#" class="hover:text-[#C40F12] transition py-2 border-b-2 border-transparent hover:border-[#C40F12]">Services</a></li>
                        <li><a href="#" class="hover:text-[#C40F12] transition py-2 border-b-2 border-transparent hover:border-[#C40F12]">Solutions</a></li>
                        <li><a href="#" class="hover:text-[#C40F12] transition py-2 border-b-2 border-[#C40F12]">Pricing</a></li>
                        <li><a href="#" class="hover:text-[#C40F12] transition py-2 border-b-2 border-transparent hover:border-[#C40F12]">About Us</a></li>
                        <li><a href="#" class="hover:text-[#C40F12] transition py-2 border-b-2 border-transparent hover:border-[#C40F12]">Resources</a></li>
                    </ul>
                </div>
                
                <div class="hidden lg:flex items-center space-x-4">
                    <a href="#" class="text-gray-700 hover:text-[#C40F12] transition">
                        <i class="fas fa-search text-lg"></i>
                    </a>
                    <div class="border-l border-gray-300 h-6 mx-2"></div>
                    <a href="#" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-[#C40F12] transition">Login</a>
                    <a href="#" class="px-4 py-2 text-sm font-medium text-white bg-[#C40F12] rounded-md hover:bg-[#A00D10] transition shadow-sm hover:shadow">Register</a>
                </div>
                
                <button class="lg:hidden text-gray-700" id="mobileMenuButton">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div class="lg:hidden hidden bg-white border-t border-gray-100 shadow-lg" id="mobileMenu">
            <div class="max-w-7xl mx-auto px-4 py-3">
                <ul class="flex flex-col space-y-3 text-gray-700 text-sm font-medium mb-6">
                    <li><a href="#" class="block py-2 hover:text-[#C40F12]">Services</a></li>
                    <li><a href="#" class="block py-2 hover:text-[#C40F12]">Solutions</a></li>
                    <li><a href="#" class="block py-2 text-[#C40F12] font-semibold">Pricing</a></li>
                    <li><a href="#" class="block py-2 hover:text-[#C40F12]">About Us</a></li>
                    <li><a href="#" class="block py-2 hover:text-[#C40F12]">Resources</a></li>
                </ul>
                <div class="flex space-x-3">
                    <a href="#" class="flex-1 px-4 py-3 text-sm font-medium text-center text-gray-700 border border-gray-300 rounded-md hover:text-[#C40F12] hover:border-[#C40F12] transition">Login</a>
                    <a href="#" class="flex-1 px-4 py-3 text-sm font-medium text-center text-white bg-[#C40F12] rounded-md hover:bg-[#A00D10] transition shadow-sm">Register</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0 bg-[url('/pattern-bg.svg')] bg-repeat"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 py-16 md:py-24 relative z-10">
            <div class="max-w-3xl">
                <div class="inline-block bg-[#C40F12] bg-opacity-20 text-[#FF8A8C] px-4 py-1 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-tag mr-2"></i> Transparent Pricing
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    Security That <span class="text-[#FF8A8C]">Scales</span> With Your Business
                </h1>
                <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                    Optimize your cybersecurity with flexible pricing designed for organizations of all sizes. Choose the plan that best fits your security needs and budget.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#pricing-plans" class="px-6 py-3 bg-[#C40F12] hover:bg-[#A00D10] rounded-md text-white font-medium transition shadow-md hover:shadow-lg">
                        View Pricing Plans
                    </a>
                    <a href="#" class="px-6 py-3 bg-white bg-opacity-10 hover:bg-opacity-20 rounded-md text-white font-medium transition border border-white border-opacity-20">
                        Schedule a Demo
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Wave Divider -->
        <div class="text-gray-50">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" fill="currentColor" preserveAspectRatio="none">
                <path d="M0,0L48,5.3C96,11,192,21,288,32C384,43,480,53,576,48C672,43,768,21,864,16C960,11,1056,21,1152,26.7C1248,32,1344,32,1392,32L1440,32L1440,80L1392,80C1344,80,1248,80,1152,80C1056,80,960,80,864,80C768,80,672,80,576,80C480,80,384,80,288,80C192,80,96,80,48,80L0,80Z"></path>
            </svg>
        </div>
    </div>

    <!-- Pricing Toggle Section -->
    <div class="max-w-6xl mx-auto px-4 pt-8 pb-4">
        <div class="flex justify-center">
            <div class="bg-white rounded-full shadow-md px-1 py-1 inline-flex">
                <button class="px-6 py-2 rounded-full bg-[#C40F12] text-white font-medium text-sm">Monthly</button>
                <button class="px-6 py-2 rounded-full text-gray-700 font-medium text-sm hover:bg-gray-100 transition">Annual (Save 15%)</button>
            </div>
        </div>
    </div>
    
    <!-- Pay-As-You-Go Option -->
    <div class="max-w-6xl mx-auto px-4 mb-12">
        <div class="flex justify-center">
            <div class="inline-block rounded-full border border-gray-200 px-6 py-3 bg-white shadow-sm">
                <div class="text-center">
                    <span class="block text-sm text-gray-500 mb-1">Single Scan Option</span>
                    <span class="font-bold text-xl text-gray-800">$25.00</span> <span class="text-sm text-gray-500">per individual scan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Standard Pricing Tiers -->
    <div id="pricing-plans" class="max-w-6xl mx-auto px-4 mb-20">
        <h2 class="text-3xl font-bold text-center mb-12">Choose Your Security Plan</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Tier 1 -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all hover:shadow-lg group relative">
                <div class="absolute inset-x-0 top-0 h-1 bg-gray-200"></div>
                <div class="p-8">
                    <div class="text-sm text-gray-500 uppercase tracking-wider font-medium mb-2">Startup</div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">$125<span class="text-base font-normal text-gray-500">/month</span></h3>
                    <p class="text-gray-600 pb-6 border-b border-gray-100 mb-6">Perfect for small businesses starting their security journey</p>
                    
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-medium text-gray-500">Scans included</span>
                            <span class="text-lg font-bold text-gray-900">50</span>
                        </div>
                        
                        <div class="w-full bg-gray-100 rounded-full h-2 mb-6">
                            <div class="bg-gray-400 h-2 rounded-full" style="width: 20%"></div>
                        </div>
                        
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-500">Price per scan</span>
                            <span class="font-semibold text-gray-900">$2.50</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">Savings</span>
                            <span class="font-semibold text-gray-500">0%</span>
                        </div>
                    </div>
                    
                    <a href="#" class="block w-full text-center px-6 py-3 rounded-lg border-2 border-[#C40F12] text-[#C40F12] font-semibold hover:bg-[#C40F12] hover:text-white transition group-hover:shadow-md">
                        Select Plan
                    </a>
                </div>
                
                <div class="bg-gray-50 px-8 py-6">
                    <p class="text-sm font-medium text-gray-700 mb-4">Plan includes:</p>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Basic vulnerability scanning</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Standard reports</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Email support</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Tier 2 - Popular -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-lg overflow-hidden transition-all hover:shadow-xl group relative transform md:scale-105 z-10">
                <div class="absolute inset-x-0 top-0 h-1 bg-[#C40F12]"></div>
                <div class="absolute top-0 right-0">
                    <div class="bg-[#C40F12] text-white text-xs font-bold px-6 py-1 rounded-bl-lg">
                        MOST POPULAR
                    </div>
                </div>
                <div class="p-8">
                    <div class="text-sm text-[#C40F12] uppercase tracking-wider font-medium mb-2">Business</div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">$300<span class="text-base font-normal text-gray-500">/month</span></h3>
                    <p class="text-gray-600 pb-6 border-b border-gray-100 mb-6">Ideal for growing businesses with advanced security needs</p>
                    
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-medium text-gray-500">Scans included</span>
                            <span class="text-lg font-bold text-gray-900">135</span>
                        </div>
                        
                        <div class="w-full bg-gray-100 rounded-full h-2 mb-6">
                            <div class="bg-[#C40F12] h-2 rounded-full" style="width: 50%"></div>
                        </div>
                        
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-500">Price per scan</span>
                            <span class="font-semibold text-gray-900">$2.22</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">Savings</span>
                            <span class="font-semibold text-green-600">11%</span>
                        </div>
                    </div>
                    
                    <a href="#" class="block w-full text-center px-6 py-3 rounded-lg border-2 bg-[#C40F12] text-white font-semibold hover:bg-[#A00D10] border-[#C40F12] transition shadow-sm group-hover:shadow-md">
                        Select Plan
                    </a>
                </div>
                
                <div class="bg-gray-50 px-8 py-6">
                    <p class="text-sm font-medium text-gray-700 mb-4">Plan includes:</p>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Advanced vulnerability scanning</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Detailed analytical reports</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Priority email & chat support</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Compliance assessment</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Tier 3 -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all hover:shadow-lg group relative">
                <div class="absolute inset-x-0 top-0 h-1 bg-gray-800"></div>
                <div class="p-8">
                    <div class="text-sm text-gray-500 uppercase tracking-wider font-medium mb-2">Enterprise</div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">$1,000<span class="text-base font-normal text-gray-500">/month</span></h3>
                    <p class="text-gray-600 pb-6 border-b border-gray-100 mb-6">Comprehensive protection for established organizations</p>
                    
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-medium text-gray-500">Scans included</span>
                            <span class="text-lg font-bold text-gray-900">500</span>
                        </div>
                        
                        <div class="w-full bg-gray-100 rounded-full h-2 mb-6">
                            <div class="bg-gray-800 h-2 rounded-full" style="width: 80%"></div>
                        </div>
                        
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-500">Price per scan</span>
                            <span class="font-semibold text-gray-900">$2.00</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">Savings</span>
                            <span class="font-semibold text-green-600">20%</span>
                        </div>
                    </div>
                    
                    <a href="#" class="block w-full text-center px-6 py-3 rounded-lg border-2 border-gray-800 text-gray-800 font-semibold hover:bg-gray-800 hover:text-white transition group-hover:shadow-md">
                        Select Plan
                    </a>
                </div>
                
                <div class="bg-gray-50 px-8 py-6">
                    <p class="text-sm font-medium text-gray-700 mb-4">Plan includes:</p>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Premium vulnerability assessment</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Custom executive reports</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>24/7 dedicated support</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Full compliance suite</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span>Security consultant</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Advanced Tiers -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1 bg-gray-200 rounded-full text-sm font-medium text-gray-800 mb-4">ENTERPRISE SOLUTIONS</span>
                <h2 class="text-3xl font-bold text-gray-900">Advanced Security Packages</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Tailored solutions for organizations with comprehensive security requirements and large-scale operations.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Tier 4 -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all hover:shadow-lg flex flex-col">
                    <div class="p-8 flex-grow">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <div class="text-sm text-gray-500 uppercase tracking-wider font-medium mb-2">Professional</div>
                                <h3 class="text-3xl font-bold text-gray-900">$2,500<span class="text-base font-normal text-gray-500">/month</span></h3>
                            </div>
                            <div class="bg-gray-100 p-3 rounded-full">
                                <i class="fas fa-building text-gray-700 text-xl"></i>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-100 pt-6 mb-6">
                            <div class="flex justify-between mb-4">
                                <span class="text-gray-600">Security Scans</span>
                                <span class="font-bold text-gray-900">1,500 scans</span>
                            </div>
                            <div class="flex justify-between mb-4">
                                <span class="text-gray-600">Price per Scan</span>
                                <span class="font-bold text-gray-900">$1.67</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Savings vs Pay-As-You-Go</span>
                                <span class="font-bold text-green-600">33% savings</span>
                            </div>
                        </div>
                        
                        <p class="text-gray-600 mb-8">
                            Ideal for financial institutions and enterprises with significant security needs.
                        </p>
                        
                        <a href="#" class="block w-full text-center px-6 py-3 rounded-lg border-2 border-gray-800 text-gray-800 font-semibold hover:bg-gray-800 hover:text-white transition">
                            Contact Sales
                        </a>
                    </div>
                    
                    <div class="bg-gray-50 px-8 py-6">
                        <p class="font-medium text-gray-700 mb-3">Enterprise features:</p>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2">
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Advanced threat detection</span>
                            </li>
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Dedicated account manager</span>
                            </li>
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>API integration</span>
                            </li>
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>SSO implementation</span>
                            </li>
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Custom security policies</span>
                            </li>
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Quarterly reviews</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Tier 5 -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all hover:shadow-lg flex flex-col">
                    <div class="p-8 flex-grow">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <div class="text-sm text-gray-500 uppercase tracking-wider font-medium mb-2">Global</div>
                                <h3 class="text-3xl font-bold text-gray-900">$10,000<span class="text-base font-normal text-gray-500">/month</span></h3>
                            </div>
                            <div class="bg-gray-100 p-3 rounded-full">
                                <i class="fas fa-globe text-gray-700 text-xl"></i>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-100 pt-6 mb-6">
                            <div class="flex justify-between mb-4">
                                <span class="text-gray-600">Security Scans</span>
                                <span class="font-bold text-gray-900">10,000 scans</span>
                            </div>
                            <div class="flex justify-between mb-4">
                                <span class="text-gray-600">Price per Scan</span>
                                <span class="font-bold text-gray-900">$1.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Savings vs Pay-As-You-Go</span>
                                <span class="font-bold text-green-600">43% savings</span>
                            </div>
                        </div>
                        
                        <p class="text-gray-600 mb-8">
                            Ultimate protection for global enterprises and government organizations.
                        </p>
                        
                        <a href="#" class="block w-full text-center px-6 py-3 rounded-lg border-2 border-gray-800 text-gray-800 font-semibold hover:bg-gray-800 hover:text-white transition">
                            Contact Sales
                        </a>
                    </div>
                    
                    <div class="bg-gray-50 px-8 py-6">
                        <p class="font-medium text-gray-700 mb-3">Global features:</p>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2">
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Everything in Professional</span>
                            </li>
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Multi-region support</span>
                            </li>
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Penetration testing</span>
                            </li>
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Security training</span>
                            </li>
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Incident response team</span>
                            </li>
                            <li class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Executive risk assessment</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Plan Comparison Table -->

    <div class="max-w-6xl mx-auto px-4 mb-20">
        <h2 class="text-3xl font-bold text-center mb-12">Compare All Plans</h2>
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-200 text-sm text-left">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-3 border border-gray-200">Feature</th>
                        <th class="px-4 py-3 border border-gray-200 text-center">Startup</th>
                        <th class="px-4 py-3 border border-gray-200 text-center">Business</th>
                        <th class="px-4 py-3 border border-gray-200 text-center">Enterprise</th>
                        <th class="px-4 py-3 border border-gray-200 text-center">Professional</th>
                        <th class="px-4 py-3 border border-gray-200 text-center">Global</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-3 border border-gray-200">Vulnerability Scanning</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Basic</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Advanced</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Premium</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Advanced</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Advanced</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 border border-gray-200">Reports</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Standard</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Detailed</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Custom</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Custom</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Executive</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 border border-gray-200">Support</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Email</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Priority Email & Chat</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">24/7 Dedicated</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Dedicated Account Manager</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Incident Response Team</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 border border-gray-200">Compliance Assessment</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">No</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Yes</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Yes</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Yes</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Yes</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 border border-gray-200">Custom Security Policies</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">No</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">No</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Yes</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Yes</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Yes</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 border border-gray-200">Penetration Testing</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">No</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">No</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">No</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">No</td>
                        <td class="px-4 py-3 border border-gray-200 text-center">Yes</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-4">InfoSec</h3>
                    <p class="text-sm">
                        Premium cybersecurity solutions tailored to protect your business and personal data.
                    </p>
                    <div class="mt-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="ml-4 text-gray-400 hover:text-white transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="ml-4 text-gray-400 hover:text-white transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Services</a></li>
                        <li><a href="#" class="hover:text-white transition">Solutions</a></li>
                        <li><a href="#" class="hover:text-white transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Resources</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-4">Support</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-4">Newsletter</h3>
                    <p class="text-sm mb-4">
                        Subscribe to our newsletter to stay updated on the latest cybersecurity trends.
                    </p>
                    <form action="#" method="POST" class="flex items-center">
                        <input type="email" name="email" placeholder="Your email" class="w-full px-4 py-2 rounded-l-md bg-gray-800 text-gray-300 border border-gray-700 focus:outline-none focus:ring-2 focus:ring-[#C40F12]">
                        <button type="submit" class="px-4 py-2 bg-[#C40F12] text-white rounded-r-md hover:bg-[#A00D10] transition">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-12 border-t border-gray-700 pt-6 text-center text-sm">
                <p>&copy; {{ date('Y') }} InfoSec. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Mobile Menu Toggle Script -->
    <script>
        document.getElementById('mobileMenuButton').addEventListener('click', function () {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
    </body>
</html>