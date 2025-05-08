<div>
<div>
    <x-modal wire:model="showModal" max-width="md">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900 flex items-center">
                <svg class="mr-2 h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
                <span>Bulk Actions</span>
            </div>
            
            <div class="mt-4">
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Bulk Operation</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>You are about to perform an action on <strong>{{ count($selectedUsers) }}</strong> selected users.</p>
                                <p class="mt-1">Please select the action you want to perform.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Selection -->
                <div class="mb-4">
                    <x-label for="action" value="Select Action" />
                    <select id="action" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model="action">
                        <option value="">-- Select Action --</option>
                        <option value="block">Block Users</option>
                        <option value="unblock">Unblock Users</option>
                        @if(auth()->user()->hasRole('super_admin'))
                            <option value="change_role">Change Role</option>
                            <option value="change_company">Change Company</option>
                            <option value="delete">Delete Users</option>
                        @endif
                        <option value="verify">Verify Email</option>
                    </select>
                    <x-input-error for="action" class="mt-1" />
                </div>
                
                <!-- Role Selection (conditional) -->
                @if($action === 'change_role')
                <div class="mb-4">
                    <x-label for="newRoleId" value="Select New Role" />
                    <select id="newRoleId" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model="newRoleId">
                        <option value="">-- Select Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="newRoleId" class="mt-1" />
                </div>
                @endif
                
                <!-- Company Selection (conditional) -->
                @if($action === 'change_company')
                <div class="mb-4">
                    <x-label for="newCompanyId" value="Select New Company" />
                    <select id="newCompanyId" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model="newCompanyId">
                        <option value="">-- Select Company --</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="newCompanyId" class="mt-1" />
                </div>
                @endif
                
                <!-- Delete Confirmation (conditional) -->
                @if($action === 'delete')
                <div class="mb-4 bg-red-50 p-4 rounded-lg border border-red-100">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Warning: Permanent Action</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>You are about to delete <strong>{{ count($selectedUsers) }}</strong> users. This action cannot be undone.</p>
                                <p class="mt-2">To confirm, please type "DELETE" in the field below:</p>
                                <input type="text" wire:model.defer="confirmationText" class="mt-1 block w-full border-red-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm text-sm" placeholder="Type DELETE to confirm">
                                <x-input-error for="confirmationText" class="mt-1" />
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 text-right">
            <x-secondary-button wire:click="closeModal" class="mr-2">
                Cancel
            </x-secondary-button>
            
            <x-button 
                wire:click="executeBulkAction" 
                wire:loading.attr="disabled"
                class="disabled:opacity-50"
                @if($action === '') disabled @endif
                @if($action === 'change_role' && $newRoleId === '') disabled @endif
                @if($action === 'change_company' && $newCompanyId === '') disabled @endif
                @if($action === 'delete' && $confirmationText !== 'DELETE') disabled @endif
            >
                <span wire:loading.remove wire:target="executeBulkAction">Apply to Selected Users</span>
                <span wire:loading wire:target="executeBulkAction">Processing...</span>
            </x-button>
        </div>
    </x-modal>
</div>
</div>
