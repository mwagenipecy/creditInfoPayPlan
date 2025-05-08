<div>
    <x-modal wire:model="showModal" max-width="md">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900 flex items-center">
                <svg class="mr-2 h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Edit User</span>
            </div>
            
            <div class="mt-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- First Name -->
                    <div>
                        <x-label for="first_name" value="First Name" />
                        <x-input id="first_name" type="text" class="mt-1 block w-full" wire:model.defer="first_name" />
                        <x-input-error for="first_name" class="mt-1" />
                    </div>
                    
                    <!-- Last Name -->
                    <div>
                        <x-label for="last_name" value="Last Name" />
                        <x-input id="last_name" type="text" class="mt-1 block w-full" wire:model.defer="last_name" />
                        <x-input-error for="last_name" class="mt-1" />
                    </div>
                </div>
                
                <!-- Email -->
                <div>
                    <x-label for="email" value="Email" />
                    <x-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="email" />
                    <x-input-error for="email" class="mt-1" />
                </div>
                
                <!-- Company Selection - Only for Super Admin -->
                @if(auth()->user()->hasRole('super_admin'))
                <div>
                    <x-label for="company_id" value="Company" />
                    <select id="company_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model.defer="company_id">
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="company_id" class="mt-1" />
                </div>
                @else
                    <input type="hidden" wire:model="company_id">
                @endif
                
                <!-- Role Selection -->
                <div>
                    <x-label for="role_id" value="Role" />
                    <select id="role_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model.defer="role_id">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="role_id" class="mt-1" />
                </div>
                
                <!-- Status Selection -->
                <div>
                    <x-label for="status" value="Status" />
                    <select id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model.defer="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending</option>
                    </select>
                    <x-input-error for="status" class="mt-1" />
                </div>
                
                <!-- Password Section -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <h3 class="text-sm font-medium text-gray-700">Change Password (optional)</h3>
                    <p class="text-xs text-gray-500 mb-4">Leave blank to keep the current password</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Password -->
                        <div>
                            <x-label for="password" value="New Password" />
                            <x-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="password" />
                            <x-input-error for="password" class="mt-1" />
                        </div>
                        
                        <!-- Password Confirmation -->
                        <div>
                            <x-label for="password_confirmation" value="Confirm New Password" />
                            <x-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="password_confirmation" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 text-right">
            <x-secondary-button wire:click="closeModal" class="mr-2">
                Cancel
            </x-secondary-button>
            
            <x-button wire:click="updateUser" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="updateUser">Update User</span>
                <span wire:loading wire:target="updateUser">Updating...</span>
            </x-button>
        </div>
    </x-modal>
</div>