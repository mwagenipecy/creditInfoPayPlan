<div>


<div class="py-1 bg-gray-50 min-h-screen">
    <div class="max-w-full mx-auto px-4 sm:px-6">
        <!-- Header Section -->
        <div class="mb-10 text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-2">User Management</h2>
            <p class="text-lg text-gray-600">Manage users, permissions, and access control across the system</p>
        </div>

        <!-- Role-Based Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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
            
            <!-- Active Admins Card -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Active Admins</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $activeAdmins }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-xs text-gray-500 font-medium">{{ $companyAdmins }} company admins</span>
                </div>
            </div>
            
            <!-- Pending Verifications -->
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
                    <span class="text-xs text-gray-500 font-medium">{{ $recentVerifications }} verifications in the last 7 days</span>
                </div>
            </div>
            
            <!-- Blocked Users -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Blocked Users</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $blockedUsers }}</p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-full">
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-xs text-gray-500 font-medium">{{ $blockedCompanies }} companies blocked</span>
                </div>
            </div>
        </div>



        <!-- Main Content Card -->
        <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100">
            <!-- Role-Based Navigation Tabs -->

            <div class="flex justify-center pt-8 pb-4">
                <div class="bg-gray-100 rounded-full shadow-sm px-1.5 py-1.5 inline-flex">
                    <button wire:click="setTab('activeTab', 'all_users')" class="px-8 py-3 rounded-full text-sm font-medium transition-all duration-200 ease-in-out {{ $activeTab === 'all_users' ? 'bg-[#C40F12] text-white shadow-md' : 'text-gray-700 hover:bg-gray-200' }}">
                        All Users
                    </button>
                    
                    @if(auth()->user()->hasRole('super_admin'))
                    <button wire:click="setTab('activeTab', 'admins')" class="px-8 py-3 rounded-full text-sm font-medium transition-all duration-200 ease-in-out {{ $activeTab === 'admins' ? 'bg-[#C40F12] text-white shadow-md' : 'text-gray-700 hover:bg-gray-200' }}">
                        Company Admins
                    </button>
                    @endif
                    
                    <button wire:click="setTab('activeTab', 'pending')" class="px-8 py-3 rounded-full text-sm font-medium transition-all duration-200 ease-in-out {{ $activeTab === 'pending' ? 'bg-[#C40F12] text-white shadow-md' : 'text-gray-700 hover:bg-gray-200' }}">
                        Pending Verification
                    </button>
                    
                    <button wire:click="setTab('activeTab', 'blocked')" class="px-8 py-3 rounded-full text-sm font-medium transition-all duration-200 ease-in-out {{ $activeTab === 'blocked' ? 'bg-[#C40F12] text-white shadow-md' : 'text-gray-700 hover:bg-gray-200' }}">
                        Blocked Users
                    </button>
                    
                    <button wire:click="setTab('activeTab', 'activity')" class="px-8 py-3 rounded-full text-sm font-medium transition-all duration-200 ease-in-out {{ $activeTab === 'activity' ? 'bg-[#C40F12] text-white shadow-md' : 'text-gray-700 hover:bg-gray-200' }}">
                        Activity Log
                    </button>
                </div>
            </div>
            
            <!-- Action Buttons (Based on current tab and user role) -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-center space-y-3 md:space-y-0 md:space-x-4 mb-8 px-6">
            @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('company_admin'))
                    <button wire:click="$dispatch('openModal', null, 'user-management.actions.create-user')" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-[#C40F12] hover:bg-[#A00D10] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C40F12] transition-all duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add New User
                    </button>
                @endif
                
                @if(auth()->user()->hasRole('super_admin'))
                    <button wire:click="$dispatch('openModal', null, 'user-management.actions.import-users')" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        Import Users
                    </button>
                    @endif

                    @if(count($selectedUsers) > 0)
                    <button wire:click="$dispatch('openModal', {{ json_encode($selectedUsers) }}, 'user-management.bulk-actions.bulk-actions')" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                        </svg>
                        Bulk Actions ({{ count($selectedUsers) }})
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
                        <input wire:model.live="searchTerm" type="text" class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-[#C40F12] focus:border-[#C40F12] shadow-sm" placeholder="Search by name, email or company...">
                    </div>
                    
                    <!-- Filters -->
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 w-full lg:w-auto">
                        @if(auth()->user()->hasRole('super_admin'))
                        <select wire:model.live="filters.company" class="pl-3 pr-10 py-2 border border-gray-200 rounded-xl focus:ring-[#C40F12] focus:border-[#C40F12] shadow-sm">
                            <option value="">All Companies</option>
                            @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        @endif
                        
                        <select wire:model.live="filters.role" class="pl-3 pr-10 py-2 border border-gray-200 rounded-xl focus:ring-[#C40F12] focus:border-[#C40F12] shadow-sm">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                            @endforeach
                        </select>
                        
                        <select wire:model.live="filters.verified" class="pl-3 pr-10 py-2 border border-gray-200 rounded-xl focus:ring-[#C40F12] focus:border-[#C40F12] shadow-sm">
                            <option value="">Email Status</option>
                            <option value="verified">Verified</option>
                            <option value="unverified">Unverified</option>
                        </select>
                        
                        <select wire:model.live="filters.status" class="pl-3 pr-10 py-2 border border-gray-200 rounded-xl focus:ring-[#C40F12] focus:border-[#C40F12] shadow-sm">
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                        </select>
                        
                        <div class="relative">
                            <input type="text" wire:model.live="filters.date_range" class="pl-3 pr-10 py-2 border border-gray-200 rounded-xl focus:ring-[#C40F12] focus:border-[#C40F12] shadow-sm" placeholder="Date Range">
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
                <!-- All Users Tab -->
                @if($activeTab === 'all_users')
                    @livewire('user-management.user-list')
                @endif

                <!-- Admins Tab -->
                @if($activeTab === 'admins')
                    @livewire('user-management.admin-list')
                @endif

                <!-- Pending Tab -->
                @if($activeTab === 'pending')
                    @livewire('user-management.pending-verification-list')
                @endif
                
                <!-- Blocked Tab -->
                @if($activeTab === 'blocked')
                    @livewire('user-management.blocked-user-list')
                @endif
                
                <!-- Activity Tab -->
                @if($activeTab === 'activity')
                    @livewire('user-management.activity-log')
                @endif
            </div>


            
        </div>
    </div>

    <!-- Modal Components -->
    @livewire('user-management.actions.create-user')
    @livewire('user-management.actions.edit-user')
   

    @livewire('user-management.actions.import-users')
 

    @livewire('user-management.actions.block-user')
    

    @livewire('user-management.actions.unblock-user')
  

    @livewire('user-management.actions.verify-user')
 

    @livewire('user-management.actions.block-company-admin')
    
    

   

    <!-- Confirmation Modal -->
@if($showDeleteModal)
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal Panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <!-- Heroicon name: outline/exclamation -->
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Delete User
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete this user? This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" 
                    wire:click="deleteUser" 
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Delete
                </button>
                <button type="button" 
                    wire:click="$set('showDeleteModal', false)" 
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endif


    
</div>


</div>