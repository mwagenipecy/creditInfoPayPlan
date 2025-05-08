<div>   


<div class="py-1 bg-gray-50 min-h-screen">
    <div class="max-w-full mx-auto px-4 sm:px-6">
        <!-- Header Section -->
        <div class="mb-10 text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-2">Enterprise User Management</h2>
            <p class="text-lg text-gray-600">Manage organizations, admins, and user access across the system</p>
        </div>

        <!-- Role-Based Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Active Companies Card -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Active Companies</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $activeCompanies }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-xs text-gray-500 font-medium">{{ $blockedCompanies }} companies blocked</span>
                </div>
            </div>
            
            <!-- Total Users Card -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-xs text-gray-500 font-medium">{{ $activeUsers }} active users</span>
                </div>
            </div>
            
            <!-- Pending Activities -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending Verifications</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pendingVerifications }}</p>
                    </div>
                    <div class="bg-amber-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-xs text-gray-500 font-medium">{{ '454' }} verifications in the last 7 days</span>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100">
            <!-- Role-Based Navigation Tabs -->
            <div class="flex justify-center pt-8 pb-4">
                <div class="bg-gray-100 rounded-full shadow-sm px-1.5 py-1.5 inline-flex">


                    @if(auth()->user()->hasRole('super_admin'))
                    <button wire:click="$set('activeTab', 'companies')" class="px-8 py-3 rounded-full text-sm font-medium transition-all duration-200 ease-in-out {{ $activeTab === 'companies' ? 'bg-[#C40F12] text-white shadow-md' : 'text-gray-700 hover:bg-gray-200' }}">
                        Companies
                    </button>
                    @endif
                    

                    <button wire:click="$set('activeTab', 'users')" class="px-8 py-3 rounded-full text-sm font-medium transition-all duration-200 ease-in-out {{ $activeTab === 'users' ? 'bg-[#C40F12] text-white shadow-md' : 'text-gray-700 hover:bg-gray-200' }}">
                        Users
                    </button>

                    
                    @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('company_admin'))
                    <button wire:click="$set('activeTab', 'roles')" class="px-8 py-3 rounded-full text-sm font-medium transition-all duration-200 ease-in-out {{ $activeTab === 'roles' ? 'bg-[#C40F12] text-white shadow-md' : 'text-gray-700 hover:bg-gray-200' }}">
                        Roles & Permissions
                    </button>
                    @endif

                    
                    <button wire:click="$set('activeTab', 'activity')" class="px-8 py-3 rounded-full text-sm font-medium transition-all duration-200 ease-in-out {{ $activeTab === 'activity' ? 'bg-[#C40F12] text-white shadow-md' : 'text-gray-700 hover:bg-gray-200' }}">
                        Activity Log
                    </button>


                </div>
            </div>
            
            <!-- Action Buttons (Based on current tab and user role) -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-center space-y-3 md:space-y-0 md:space-x-4 mb-8 px-6">
                @if($activeTab === 'companies' && auth()->user()->hasRole('super_admin'))
                <button wire:click="$set('showCreateCompanyModal', true)" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-[#C40F12] hover:bg-[#A00D10] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C40F12] transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add New Company
                </button>
                @endif
                
                @if($activeTab === 'users')
                    @if(auth()->user()->hasRole('super_admin') || (auth()->user()->hasRole('company_admin') && !auth()->user()->company->is_blocked))
                  
                    <button wire:click="$set('showCreateUserModal', true)" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-[#C40F12] hover:bg-[#A00D10] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C40F12] transition-all duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add New User
                    </button>
                    @endif
                    
                    @if(auth()->user()->hasRole('super_admin'))
                    <button wire:click="$set('showImportUsersModal', true)" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        Import Users
                    </button>
                    @endif
                @endif
                
                @if($activeTab === 'roles' && auth()->user()->hasRole('super_admin'))
                <button wire:click="$set('showCreateRoleModal', true)" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-[#C40F12] hover:bg-[#A00D10] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C40F12] transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Create New Role
                </button>
                @endif
                
                @if(count($selectedItems) > 0)
                <button wire:click="$set('showBulkActionModal', true)" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                    </svg>
                    Bulk Actions ({{ count($selectedItems) }})
                </button>
                @endif
                
                <button wire:click="exportData" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    Export
                </button>
            </div>
            
            <!-- Filter & Search -->
            <div class="px-6 pb-6">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                    <!-- Search Box -->
                    <div class="relative w-full lg:w-1/3">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input wire:model.debounce.300ms="searchTerm" type="text" class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-[#C40F12] focus:border-[#C40F12] shadow-sm" placeholder="Search by name, email or company...">
                    </div>
                    
                    <!-- Filters -->
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 w-full lg:w-auto">
                        @if($activeTab === 'companies' || (auth()->user()->hasRole('super_admin') && $activeTab === 'users'))
                        <select wire:model="filters.status" class="pl-3 pr-10 py-2 border border-gray-200 rounded-xl focus:ring-[#C40F12] focus:border-[#C40F12] shadow-sm">
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="blocked">Blocked</option>
                        </select>
                        @endif
                        
                        @if($activeTab === 'users')
                            @if(auth()->user()->hasRole('super_admin'))
                            <select wire:model="filters.company" class="pl-3 pr-10 py-2 border border-gray-200 rounded-xl focus:ring-[#C40F12] focus:border-[#C40F12] shadow-sm">
                                <option value="">All Companies</option>
                                @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                            @endif
                            
                            <select wire:model="filters.role" class="pl-3 pr-10 py-2 border border-gray-200 rounded-xl focus:ring-[#C40F12] focus:border-[#C40F12] shadow-sm">
                                <option value="">All Roles</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            
                            <select wire:model="filters.verified" class="pl-3 pr-10 py-2 border border-gray-200 rounded-xl focus:ring-[#C40F12] focus:border-[#C40F12] shadow-sm">
                                <option value="">Email Status</option>
                                <option value="verified">Verified</option>
                                <option value="unverified">Unverified</option>
                            </select>
                        @endif
                        
                        <div class="relative">
                            <input type="text" wire:model="filters.date_range" class="pl-3 pr-10 py-2 border border-gray-200 rounded-xl focus:ring-[#C40F12] focus:border-[#C40F12] shadow-sm" placeholder="Date Range">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        
                        <div>
                            <select wire:model="perPage" class="pl-3 pr-10 py-2 border border-gray-200 rounded-xl focus:ring-[#C40F12] focus:border-[#C40F12] shadow-sm">
                                <option value="10">10 per page</option>
                                <option value="25">25 per page</option>
                                <option value="50">50 per page</option>
                                <option value="100">100 per page</option>
                            </select>
                        </div>
                        
                        <button wire:click="resetFilters" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                            </svg>
                            Reset
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="border-t border-gray-100">
              

            </div>




        </div>
    </div>

    <!-- Modals -->
   
</div>

<!-- Companies Tab Content -->
<div class="companies-tab overflow-x-auto px-4 pb-4">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-4 text-left">
                    <div class="flex items-center">
                        <input id="selectAll" type="checkbox" wire:model="selectAll" class="h-4 w-4 text-[#C40F12] focus:ring-[#C40F12] border-gray-300 rounded">
                    </div>
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <div class="flex items-center cursor-pointer" wire:click="sortBy('name')">
                        Company Name
                        @if($sortField === 'name')
                            <svg class="ml-1 h-4 w-4 {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Users
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Admins
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <div class="flex items-center cursor-pointer" wire:click="sortBy('created_at')">
                        Registration Date
                        @if($sortField === 'created_at')
                            <svg class="ml-1 h-4 w-4 {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                </th>
                <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($companies as $company)
            <tr class="hover:bg-gray-50 transition duration-150">
                <td class="px-6 py-5">
                    <div class="flex items-center">
                        <input type="checkbox" wire:model="selectedItems" value="{{ $company->id }}" class="h-4 w-4 text-[#C40F12] focus:ring-[#C40F12] border-gray-300 rounded">
                    </div>
                </td>
                <td class="px-6 py-5 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-full flex items-center justify-center">
                            @if($company->logo_path)
                                <img class="h-12 w-12 rounded-full object-cover" src="{{ Storage::url($company->logo_path) }}" alt="{{ $company->name }}">
                            @else
                                <span class="text-gray-600 font-medium">{{ substr($company->name, 0, 2) }}</span>
                            @endif
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $company->name }}</div>
                            @if($company->website)
                                <div class="text-xs text-gray-500">{{ $company->website }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-6 py-5 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ $company->users_count }}</div>
                    <div class="text-xs text-gray-500">{{ $company->active_users_count }} active</div>
                </td>
                <td class="px-6 py-5 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ $company->admins_count }}</div>
                    <div class="flex -space-x-2 overflow-hidden mt-1">
                        @foreach($company->admins as $admin)
                        <div class="inline-block h-6 w-6 rounded-full ring-2 ring-white bg-gray-100 flex items-center justify-center text-xs text-gray-600">
                            {{ substr($admin->first_name, 0, 1) }}{{ substr($admin->last_name, 0, 1) }}
                        </div>
                        @endforeach
                    </div>
                </td>
                <td class="px-6 py-5 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ $company->created_at->format('M d, Y') }}</div>
                    <div class="text-xs text-gray-500">{{ $company->created_at->diffForHumans() }}</div>
                </td>
                <td class="px-6 py-5 whitespace-nowrap">
                    @if($company->is_blocked)
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        Blocked
                    </span>
                    @else
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Active
                    </span>
                    @endif
                </td>
                <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end space-x-3">
                        <button wire:click="editCompany({{ $company->id }})" class="text-indigo-600 hover:text-indigo-900 transition bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg" title="Edit Company">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button wire:click="viewCompanyUsers({{ $company->id }})" class="text-blue-600 hover:text-blue-900 transition bg-blue-50 hover:bg-blue-100 p-2 rounded-lg" title="View Users">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>
                        @if($company->is_blocked)
                        <button wire:click="unblockCompany({{ $company->id }})" class="text-green-600 hover:text-green-900 transition bg-green-50 hover:bg-green-100 p-2 rounded-lg" title="Unblock Company">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                        @else
                        <button wire:click="blockCompany({{ $company->id }})" class="text-red-600 hover:text-red-900 transition bg-red-50 hover:bg-red-100 p-2 rounded-lg" title="Block Company">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-10 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="h-10 w-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="mt-2 text-gray-500 text-base">No companies found.</span>
                        <button wire:click="$set('showCreateCompanyModal', true)" class="mt-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#C40F12] hover:bg-[#A00D10]">
                            Add New Company
                        </button>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="mt-4">

</div>
</div>

<!-- Users Tab Content -->
<div class="users-tab overflow-x-auto px-4 pb-4">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-4 text-left">
                    <div class="flex items-center">
                        <input id="selectAllUsers" type="checkbox" wire:model="selectAll" class="h-4 w-4 text-[#C40F12] focus:ring-[#C40F12] border-gray-300 rounded">
                    </div>
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <div class="flex items-center cursor-pointer" wire:click="sortBy('name')">
                        Name
                        @if($sortField === 'name')
                            <svg class="ml-1 h-4 w-4 {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <div class="flex items-center cursor-pointer" wire:click="sortBy('email')">
                        Email
                        @if($sortField === 'email')
                            <svg class="ml-1 h-4 w-4 {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <div class="flex items-center cursor-pointer" wire:click="sortBy('company_id')">
                        Company
                        @if($sortField === 'company_id')
                            <svg class="ml-1 h-4 w-4 {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <div class="flex items-center cursor-pointer" wire:click="sortBy('role_id')">
                        Role
                        @if($sortField === 'role_id')
                            <svg class="ml-1 h-4 w-4 {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                </th>
                <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50 transition duration-150 {{ $user->company && $user->company->is_blocked ? 'bg-red-50' : '' }}">
                <td class="px-6 py-5">
                    <div class="flex items-center">
                        <input type="checkbox" wire:model="selectedItems" value="{{ $user->id }}" class="h-4 w-4 text-[#C40F12] focus:ring-[#C40F12] border-gray-300 rounded">
                    </div>
                </td>
                <td class="px-6 py-5 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-full flex items-center justify-center">
                            @if($user->profile_photo_path)
                                <img class="h-12 w-12 rounded-full object-cover" src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}">
                            @else
                                <span class="text-gray-600 font-medium">{{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</div>
                            <div class="text-xs text-gray-500">ID: {{ $user->id }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-5 whitespace-nowrap">
                    <div class="text-sm text-gray-900 {{ $user->email_verified_at ? '' : 'text-amber-600' }}">
                        {{ $user->email }}
                        @if(!$user->email_verified_at)
                            <span class="ml-1 text-xs text-amber-600">(Unverified)</span>
                        @endif
                    </div>
                    <div class="text-xs text-gray-500">
                        Created: {{ $user->created_at->format('M d, Y') }}
                    </div>
                </td>
                <td class="px-6 py-5 whitespace-nowrap">
                    @if($user->company)
                        <div class="flex items-center">
                            <div class="h-6 w-6 bg-gray-100 rounded-full flex items-center justify-center mr-2">
                                <span class="text-gray-600 text-xs">{{ substr($user->company->name, 0, 2) }}</span>
                            </div>
                            <div class="text-sm text-gray-900">
                                {{ $user->company->name }}
                                @if($user->company->is_blocked)
                                <span class="ml-1 text-xs text-red-600">(Blocked)</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <span class="text-sm text-gray-500">No Company</span>
                    @endif
                </td>
                <td class="px-6 py-5 whitespace-nowrap">
                    @if($user->role)
                        @if($user->role->name === 'super_admin')
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                            Super Admin
                        </span>
                        @elseif($user->role->name === 'company_admin')
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            Company Admin
                        </span>
                        @else
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                            {{ $user->role->display_name ?? 'Regular User' }}
                        </span>
                        @endif
                    @else
                        <span class="text-sm text-gray-500">No Role</span>
                    @endif
                </td>
                <td class="px-6 py-5 whitespace-nowrap">
                    @if($user->company && $user->company->is_blocked)
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        Blocked (Company)
                    </span>
                    @elseif($user->is_blocked)
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        Blocked
                    </span>
                    @else
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Active
                    </span>
                    @endif
                </td>
                <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end space-x-3">
                        @if(auth()->user()->hasRole('super_admin') || (auth()->user()->hasRole('company_admin') && $user->company_id === auth()->user()->company_id))
                        <button wire:click="editUser({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900 transition bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg" title="Edit User">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        
                        @if(auth()->user()->hasRole('super_admin') || (auth()->user()->hasRole('company_admin') && $user->role && $user->role->name !== 'company_admin'))
                            @if($user->is_blocked)
                            <button wire:click="unblockUser({{ $user->id }})" class="text-green-600 hover:text-green-900 transition bg-green-50 hover:bg-green-100 p-2 rounded-lg" title="Unblock User">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                            @else
                            <button wire:click="blockUser({{ $user->id }})" class="text-red-600 hover:text-red-900 transition bg-red-50 hover:bg-red-100 p-2 rounded-lg" title="Block User">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </button>
                            @endif
                        @endif
                        
                        @if(auth()->user()->hasRole('super_admin'))
                        <button wire:click="confirmUserDeletion({{ $user->id }})" class="text-red-600 hover:text-red-900 transition bg-red-50 hover:bg-red-100 p-2 rounded-lg" title="Delete User">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                        @endif
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-10 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="h-10 w-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="mt-2 text-gray-500 text-base">No users found.</span>
                        @if(auth()->user()->hasRole('super_admin') || (auth()->user()->hasRole('company_admin') && !auth()->user()->company->is_blocked))
                        <button wire:click="$set('showCreateUserModal', true)" class="mt-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#C40F12] hover:bg-[#A00D10]">
                            Add New User
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="mt-4">


</div>
</div>






</div>
