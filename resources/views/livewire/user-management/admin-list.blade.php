<div>
    <div class="overflow-x-auto px-4 pb-4">
        <!-- Filters specific to admins -->
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
                
                <select wire:model.live="filters.status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Blocked</option>
                </select>
            </div>
            
            <div>
                <span class="text-sm text-gray-600">{{ $admins->total() }} admins found</span>
            </div>
        </div>
        
        <!-- Admin table -->
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left">
                        <div class="flex items-center">
                            <input id="selectAllAdmins" type="checkbox" wire:model.live="selectAll" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
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
                        <div class="flex items-center cursor-pointer" wire:click="sortBy('role_id')">
                            Role
                            @if($sortField === 'role_id')
                            <svg class="ml-1 h-4 w-4 {{ $sortDirection === 'asc' ? '' : 'transform rotate-180' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($admins as $admin)
                <tr class="hover:bg-gray-50 transition duration-150 {{ $admin->company && $admin->company->is_blocked ? 'bg-red-50' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <input type="checkbox" wire:model.live="selectedAdmins" value="{{ $admin->id }}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center">
                                @if($admin->profile_photo_path)
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($admin->profile_photo_path) }}" alt="{{ $admin->name }}">
                                @else
                                <span class="text-gray-600 font-medium">{{ substr($admin->first_name, 0, 1) }}{{ substr($admin->last_name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $admin->first_name }} {{ $admin->last_name }}</div>
                                <div class="text-xs text-gray-500">ID: {{ $admin->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 {{ $admin->email_verified_at ? '' : 'text-amber-600' }}">
                            {{ $admin->email }}
                            @if(!$admin->email_verified_at)
                            <span class="ml-1 text-xs text-amber-600">(Unverified)</span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-500">
                            Created: {{ $admin->created_at->format('M d, Y') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($admin->company)
                        <div class="flex items-center">
                            <div class="h-6 w-6 bg-gray-100 rounded-full flex items-center justify-center mr-2">
                                <span class="text-gray-600 text-xs">{{ substr($admin->company->name, 0, 2) }}</span>
                            </div>
                            <div class="text-sm text-gray-900">
                                {{ $admin->company->name }}
                                @if($admin->company->is_blocked)
                                <span class="ml-1 text-xs text-red-600">(Blocked)</span>
                                @endif
                            </div>
                        </div>
                        @else
                        <span class="text-sm text-gray-500">No Company</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($admin->role)
                        @if($admin->role->name === 'super_admin')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                            Super Admin
                        </span>
                        @elseif($admin->role->name === 'company_admin')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            Company Admin
                        </span>
                        @endif
                        @else
                        <span class="text-sm text-gray-500">No Role</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($admin->company && $admin->company->is_blocked)
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Blocked (Company)
                        </span>
                        @elseif($admin->status === 'inactive')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Blocked
                        </span>
                        @else
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            @if(auth()->user()->hasRole('super_admin'))
                            <button wire:click="editUser({{ $admin->id }})" class="text-indigo-600 hover:text-indigo-900 transition bg-indigo-50 hover:bg-indigo-100 p-2 rounded" title="Edit Admin">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            
                            @if($admin->role->name === 'company_admin' && $admin->status !== 'inactive')
                            <button wire:click="blockCompanyAdmin({{ $admin->id }})" class="text-orange-600 hover:text-orange-900 transition bg-orange-50 hover:bg-orange-100 p-2 rounded" title="Block Admin & Company">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </button>
                            @endif
                            
                            @if($admin->status === 'inactive')
                            <button wire:click="unblockUser( {{ $admin->id }} )" class="text-green-600 hover:text-green-900 transition bg-green-50 hover:bg-green-100 p-2 rounded" title="Unblock Admin">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                            @elseif($admin->role->name !== 'super_admin')
                            <button wire:click="blockUser({{  $admin->id }})" class="text-red-600 hover:text-red-900 transition bg-red-50 hover:bg-red-100 p-2 rounded" title="Block Admin">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span class="mt-2 text-gray-500 text-base">No administrators found.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="mt-4">
            {{ $admins->links() }}
        </div>
    </div>
</div>