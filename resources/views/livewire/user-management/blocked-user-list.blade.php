<div>
    <div class="overflow-x-auto px-4 pb-4">
        <!-- Filters specific to blocked users -->
        <div class="mb-4 flex items-center justify-between">
            <div class="flex space-x-2">
                @if(auth()->user()->hasRole('super_admin'))
                <select wire:model.live="filters.company" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">All Companies</option>
                    @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
                @endif
                
                <select wire:model.live="filters.role" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                    @endforeach
                </select>
                
                <select wire:model.live="filters.block_type" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">All Block Types</option>
                    <option value="user">User Block</option>
                    <option value="company">Company Block</option>
                </select>
            </div>
            
            <div>
                <button type="button" wire:click="unblockSelected" 
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50"
                    {{ count($selectedUsers) > 0 ? '' : 'disabled' }}>
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Unblock Selected ({{ count($selectedUsers) }})
                </button>
            </div>
        </div>
        
        <!-- Blocked Users table -->
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left">
                        <div class="flex items-center">
                            <input id="selectAllBlocked" type="checkbox" wire:model.live="selectAll" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer" wire:click="sortBy('name')">
                            Name
                            @if($sortField === 'name')
                            <svg class="ml-1 h-4 w-4 {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer" wire:click="sortBy('email')">
                            Email
                            @if($sortField === 'email')
                            <svg class="ml-1 h-4 w-4 {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer" wire:click="sortBy('company_id')">
                            Company
                            @if($sortField === 'company_id')
                            <svg class="ml-1 h-4 w-4 {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Block Type
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    <div class="flex items-center cursor-pointer" wire:click="sortBy('updated_at')">
                            Blocked On
                            @if($sortField === 'updated_at')
                            <svg class="ml-1 h-4 w-4 {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($blockedUsers as $user)
                <tr class="hover:bg-gray-50 transition duration-150 {{ $user->company && $user->company->is_blocked ? 'bg-red-50' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <input type="checkbox" wire:model.live="selectedUsers" value="{{ $user->id }}" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded" {{ $user->company && $user->company->is_blocked ? 'disabled' : '' }}>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center">
                                @if($user->profile_photo_path)
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}">
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
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ $user->email }}
                            @if(!$user->email_verified_at)
                            <span class="ml-1 text-xs text-amber-600">(Unverified)</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
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
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->company && $user->company->is_blocked)
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Company Block
                        </span>
                        @else
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                            User Block
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $user->updated_at->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $user->updated_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('company_admin'))
                            <!-- <button wire:click="$dispatch('editUser', { id: {{ $user->id }} })" class="text-indigo-600 hover:text-indigo-900 transition bg-indigo-50 hover:bg-indigo-100 p-2 rounded" title="Edit User">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button> -->
                            
                            <!-- Only show unblock button for users not in blocked companies -->
                            @if(!($user->company && $user->company->is_blocked))
                            <button wire:click="unblockUser({{ $user->id }})" class="text-green-600 hover:text-green-900 transition bg-green-50 hover:bg-green-100 p-2 rounded" title="Unblock User">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="mt-2 text-gray-500 text-base">No blocked users found.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="mt-4">
            {{ $blockedUsers->links() }}
        </div>
    </div>
</div>

