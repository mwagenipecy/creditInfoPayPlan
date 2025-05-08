<div>
    <div class="overflow-x-auto px-4 pb-4">
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
                            <input type="checkbox" wire:model="selectedUsers" value="{{ $user->id }}" class="h-4 w-4 text-[#C40F12] focus:ring-[#C40F12] border-gray-300 rounded">
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
                        @elseif($user->status === 'inactive')
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Blocked
                        </span>
                        @elseif($user->status === 'pending')
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Pending
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
                            
                            <!-- View Profile Action -->
                            <button wire:click="viewUserProfile({{ $user->id }})" class="text-blue-600 hover:text-blue-900 transition bg-blue-50 hover:bg-blue-100 p-2 rounded-lg" title="View Profile">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            
                            @if(!$user->email_verified_at)
                            <!-- Verify Email Action -->
                            <button wire:click="verifyUser({{ $user->id }})" class="text-amber-600 hover:text-amber-900 transition bg-amber-50 hover:bg-amber-100 p-2 rounded-lg" title="Verify Email">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                            @endif
                            
                            @if(auth()->user()->hasRole('super_admin') || (auth()->user()->hasRole('company_admin') && $user->role && $user->role->name !== 'company_admin'))
                                @if($user->status === 'inactive')
                                <!-- Unblock User Action -->
                                <button wire:click="unblockUser({{ $user->id }})" class="text-green-600 hover:text-green-900 transition bg-green-50 hover:bg-green-100 p-2 rounded-lg" title="Unblock User">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                                @else
                                <!-- Block User Action -->
                                <button wire:click="blockUser({{ $user->id }})" class="text-red-600 hover:text-red-900 transition bg-red-50 hover:bg-red-100 p-2 rounded-lg" title="Block User">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                </button>
                                @endif
                            @endif
                            
                            <!-- Special action for super admin to block company admin -->
                            @if(auth()->user()->hasRole('super_admin') && $user->role && $user->role->name === 'company_admin' && $user->status !== 'inactive')
                            <button wire:click="blockCompanyAdmin({{ $user->id }})" class="text-orange-600 hover:text-orange-900 transition bg-orange-50 hover:bg-orange-100 p-2 rounded-lg" title="Block Admin & Company">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </button>
                            @endif
                            
                            @if(auth()->user()->hasRole('super_admin'))
                            <!-- Delete User Action -->
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
                            <button wire:click="$emitTo('user-management.actions.create-user', 'openModal')" class="mt-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#C40F12] hover:bg-[#A00D10]">
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
            {{ $users->links() }}
        </div>
    </div>
</div>