<div>



    {{-- Success is as dangerous as failure. --}}
    <div>
    {{-- Success is as dangerous as failure. --}}
    <div class="py-1 bg-gray-50 min-h-screen">
    <div class="max-w-full mx-auto px-4 sm:px-6 ">
        <!-- Header Section -->
        <div class="mb-10 text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-2">User Management Portal</h2>
            <p class="text-lg text-gray-600">Manage internal users and control external system access</p>
        </div>
        <!-- Main Content Card -->
        <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100">
            <!-- Tab Navigation -->
            <div class="flex justify-center pt-8 pb-4">
                <div class="bg-gray-100 rounded-full shadow-sm px-1.5 py-1.5 inline-flex">
                    <button wire:click="$set('activeTab', 'internal')" class="px-8 py-3 rounded-full text-sm font-medium transition-all duration-200 ease-in-out {{ $activeTab === 'internal' ? 'bg-[#C40F12] text-white shadow-md' : 'text-gray-700 hover:bg-gray-200' }}">
                        Internal Users
                    </button>
                    <button wire:click="$set('activeTab', 'external')" class="px-8 py-3 rounded-full text-sm font-medium transition-all duration-200 ease-in-out {{ $activeTab === 'external' ? 'bg-[#C40F12] text-white shadow-md' : 'text-gray-700 hover:bg-gray-200' }}">
                        External Users
                    </button>
                    @if(auth()->user()->isAdmin())
                    <button wire:click="$set('activeTab', 'requests')" class="px-8 py-3 rounded-full text-sm font-medium transition-all duration-200 ease-in-out {{ $activeTab === 'requests' ? 'bg-[#C40F12] text-white shadow-md' : 'text-gray-700 hover:bg-gray-200' }} flex items-center">
                        Access Requests
                        @if($pendingRequests > 0)
                        <span class="ml-2 bg-white text-[#C40F12] text-xs font-semibold rounded-full w-6 h-6 flex items-center justify-center">{{ $pendingRequests }}</span>
                        @endif
                    </button>
                    @endif
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-center space-y-3 md:space-y-0 md:space-x-4 mb-8 px-6">
                @if(auth()->user()->isAdmin())
                <button wire:click="$set('showCreateModal', true)" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-[#C40F12] hover:bg-[#A00D10] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C40F12] transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Create Internal User
                </button>
                @endif
                
                @if(auth()->user()->isCompany())
                <button wire:click="$set('showRequestModal', true)" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    Request External Access
                </button>
                @endif
            </div>
            
            <!-- Search Bar -->
            <div class="px-6 pb-6">
                <div class="flex justify-center">
                    <div class="relative w-full max-w-lg">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input wire:model.debounce.300ms="searchTerm" type="text" class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-[#C40F12] focus:border-[#C40F12] shadow-sm" placeholder="Search by name, email or role...">
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="border-t border-gray-100">
                @if($activeTab === 'internal')
                <div class="overflow-x-auto px-4 pb-4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($internalUsers as $user)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-full flex items-center justify-center">
                                            <span class="text-gray-600 font-medium">{{ substr($user->name, 0, 2) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @if($user->role === 'admin')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                        Admin
                                    </span>
                                    @elseif($user->role === 'company')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Company
                                    </span>
                                    @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        User
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <button wire:click="editUser({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900 transition bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button wire:click="confirmUserDeletion({{ $user->id }})" class="text-red-600 hover:text-red-900 transition bg-red-50 hover:bg-red-100 p-2 rounded-lg">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @elseif($activeTab === 'external')
                <div class="px-6 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($externalUsers as $user)
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-6">
                                    <div class="flex-shrink-0 h-14 w-14 bg-gray-100 rounded-full flex items-center justify-center">
                                        <span class="text-gray-600 font-medium text-lg">{{ substr($user->name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        @if($user->hasAccess)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Has Access
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            No Access
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-1">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-500 mb-5">{{ $user->email }}</p>
                                
                                @if($user->hasAccess)
                                <div class="border-t border-gray-100 pt-5 mb-5">
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="text-gray-500">Access Level:</span>
                                        <span class="font-medium">{{ ucfirst($user->accessLevel) }}</span>
                                    </div>
                                    @if($user->expiryDate)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Expires:</span>
                                        <span class="font-medium">{{ $user->expiryDate }}</span>
                                    </div>
                                    @endif
                                </div>
                                @endif
                                
                                <div class="flex space-x-2">
                                    @if(!$user->hasAccess)
                                    <button wire:click="requestAccessForUser({{ $user->id }})" class="flex-1 inline-flex justify-center items-center px-4 py-3 border border-transparent text-sm font-medium rounded-xl text-white bg-[#C40F12] hover:bg-[#A00D10] transition-all duration-200">
                                        Request Access
                                    </button>
                                    @else
                                    <button wire:click="revokeAccess({{ $user->id }})" class="flex-1 inline-flex justify-center items-center px-4 py-3 border border-gray-300 text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200">
                                        Revoke Access
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @elseif($activeTab === 'requests')
                <div class="overflow-x-auto px-4 pb-4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requester</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Access Level</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requested On</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($accessRequests as $request)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $request->requesterName }}</div>
                                    <div class="text-sm text-gray-500">{{ $request->requesterEmail }}</div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $request->type === 'individual' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ ucfirst($request->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $request->type === 'individual' ? $request->targetName : $request->groupName }}
                                    </div>
                                    @if($request->type === 'group')
                                    <div class="text-xs text-gray-500">{{ $request->userCount }} users</div>
                                    @endif
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $request->accessLevel === 'read' ? 'bg-green-100 text-green-800' : 
                                           ($request->accessLevel === 'write' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($request->accessLevel) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-500">
                                    {{ $request->requestedOn }}
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <button wire:click="approveRequest({{ $request->id }})" class="text-green-600 hover:text-green-900 transition bg-green-50 hover:bg-green-100 p-2 rounded-lg">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                        <button wire:click="rejectRequest({{ $request->id }})" class="text-red-600 hover:text-red-900 transition bg-red-50 hover:bg-red-100 p-2 rounded-lg">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Create/Edit User Modal -->
@if($showCreateModal)
<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form wire:submit.prevent="{{ $userId ? 'updateUser' : 'createUser' }}">
                <!-- Modal Header -->
                <div class="bg-gray-50 px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="bg-[#C40F12] rounded-full p-3 mr-4 shadow-md">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl leading-6 font-bold text-gray-900" id="modal-title">
                            {{ $userId ? 'Edit User' : 'Create New User' }}
                        </h3>
                    </div>
                </div>
                
                <!-- Modal Body -->
                <div class="px-6 py-6 space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" wire:model="name" id="name" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#C40F12] focus:ring focus:ring-[#C40F12] focus:ring-opacity-50 transition py-3">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" wire:model="email" id="email" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#C40F12] focus:ring focus:ring-[#C40F12] focus:ring-opacity-50 transition py-3">
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select wire:model="role" id="role" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#C40F12] focus:ring focus:ring-[#C40F12] focus:ring-opacity-50 transition py-3">
                            <option value="user">Standard User</option>
                            <option value="company">Company User</option>
                            <option value="admin">Administrator</option>
                        </select>
                        @error('role') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ $userId ? 'New Password (leave blank to keep current)' : 'Password' }}
                        </label>
                        <input type="password" wire:model="password" id="password" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#C40F12] focus:ring focus:ring-[#C40F12] focus:ring-opacity-50 transition py-3">
                        @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-5 border-t border-gray-100 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3">
                    <button type="button" wire:click="$set('showCreateModal', false)" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-5 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C40F12] transition-all duration-200 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-3 bg-[#C40F12] text-base font-medium text-white hover:bg-[#A00D10] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C40F12] transition-all duration-200 sm:w-auto sm:text-sm">
                        {{ $userId ? 'Update User' : 'Create User' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Request Access Modal -->
@if($showRequestModal)
<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form wire:submit.prevent="createAccessRequest">
                <!-- Modal Header -->
                <div class="bg-gray-50 px-6 py-5 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="bg-gray-800 rounded-full p-3 mr-4 shadow-md">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-xl leading-6 font-bold text-gray-900" id="modal-title">
                            Request External User Access
                        </h3>
                    </div>
                </div>
                
                <!-- Modal Body -->
                <div class="px-6 py-6 space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">Request Type</label>
                        <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-3 sm:space-y-0">
                            <div class="flex items-center border border-gray-200 rounded-xl p-4 cursor-pointer hover:bg-gray-50 transition-all duration-200" 
                                 onclick="document.getElementById('request-individual').checked = true; Livewire.emit('updateRequestType', 'individual')">
                                <input wire:model="requestType" id="request-individual" type="radio" value="individual" class="h-5 w-5 text-[#C40F12] focus:ring-[#C40F12] border-gray-300">
                                <label for="request-individual" class="ml-3 block text-sm font-medium text-gray-700">
    Individual User
    <p class="text-xs text-gray-500 mt-1">Request access for a single external user</p>
</label>
</div>
<div class="flex items-center border border-gray-200 rounded-xl p-4 cursor-pointer hover:bg-gray-50 transition-all duration-200" 
     onclick="document.getElementById('request-group').checked = true; Livewire.emit('updateRequestType', 'group')">
<input wire:model="requestType" id="request-group" type="radio" value="group" class="h-5 w-5 text-[#C40F12] focus:ring-[#C40F12] border-gray-300">
<label for="request-group" class="ml-3 block text-sm font-medium text-gray-700">
    User Group
    <p class="text-xs text-gray-500 mt-1">Request access for multiple external users</p>
</label>
</div>
</div>
</div>

@if($requestType === 'individual')
<div>
    <label for="targetUser" class="block text-sm font-medium text-gray-700 mb-1">Select User</label>
    <select wire:model="targetUserId" id="targetUser" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#C40F12] focus:ring focus:ring-[#C40F12] focus:ring-opacity-50 transition py-3">
        <option value="">Select a user</option>
        @foreach($availableUsers as $user)
        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
        @endforeach
    </select>
    @error('targetUserId') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
</div>
@else
<div>
    <label for="groupName" class="block text-sm font-medium text-gray-700 mb-1">Group Name</label>
    <input type="text" wire:model="groupName" id="groupName" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#C40F12] focus:ring focus:ring-[#C40F12] focus:ring-opacity-50 transition py-3" placeholder="E.g. Marketing Team">
    @error('groupName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
</div>

<div>
    <label for="userCount" class="block text-sm font-medium text-gray-700 mb-1">Number of Users</label>
    <input type="number" wire:model="userCount" id="userCount" min="2" max="50" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#C40F12] focus:ring focus:ring-[#C40F12] focus:ring-opacity-50 transition py-3">
    @error('userCount') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
</div>
@endif

<div>
    <label for="accessLevel" class="block text-sm font-medium text-gray-700 mb-1">Access Level</label>
    <select wire:model="accessLevel" id="accessLevel" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#C40F12] focus:ring focus:ring-[#C40F12] focus:ring-opacity-50 transition py-3">
        <option value="read">Read Only</option>
        <option value="write">Read & Write</option>
        <option value="admin">Full Admin</option>
    </select>
    @error('accessLevel') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
</div>

<div>
    <label for="justification" class="block text-sm font-medium text-gray-700 mb-1">Justification</label>
    <textarea wire:model="justification" id="justification" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#C40F12] focus:ring focus:ring-[#C40F12] focus:ring-opacity-50 transition py-3" placeholder="Please explain why this access is required..."></textarea>
    @error('justification') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
</div>

<div>
    <label for="expiryDate" class="block text-sm font-medium text-gray-700 mb-1">Access Expiry Date</label>
    <input type="date" wire:model="expiryDate" id="expiryDate" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#C40F12] focus:ring focus:ring-[#C40F12] focus:ring-opacity-50 transition py-3">
    @error('expiryDate') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
</div>
</div>

<!-- Modal Footer -->
<div class="bg-gray-50 px-6 py-5 border-t border-gray-100 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3">
    <button type="button" wire:click="$set('showRequestModal', false)" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-5 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 sm:mt-0 sm:w-auto sm:text-sm">
        Cancel
    </button>
    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-3 bg-gray-800 text-base font-medium text-white hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 transition-all duration-200 sm:w-auto sm:text-sm">
        Submit Request
    </button>
</div>
</form>
</div>
</div>
</div>
@endif

<!-- Delete Confirmation Modal -->
@if($showDeleteModal)
<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-6 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
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
            <div class="bg-gray-50 px-6 py-5 sm:flex sm:flex-row-reverse">
                <button type="button" wire:click="deleteUser" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Delete
                </button>
                <button type="button" wire:click="$set('showDeleteModal', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endif
</div>                                








</div>
