<div>
    <x-modal wire:model="showModal" max-width="md">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900 flex items-center">
                <svg class="mr-2 h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Unblock User</span>
            </div>
            
            <div class="mt-4">
                @if($user && $user->company && $user->company->is_blocked)
                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Warning: Company is blocked</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>This user belongs to <strong>{{ $user->company->name }}</strong>, which is currently blocked.</p>
                                <p class="mt-1">While you can unblock this user, they will still be unable to access the system until the company is unblocked as well.</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <p class="text-sm text-gray-600 mb-4">
                    Are you sure you want to unblock <strong>{{ $user->name ?? '' }}</strong>? 
                    This will restore their access to the system.
                </p>
            </div>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 text-right">
            <x-secondary-button wire:click="closeModal" class="mr-2">
                Cancel
            </x-secondary-button>
            
            <x-button wire:click="confirmUnblock" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="confirmUnblock">Unblock User</span>
                <span wire:loading wire:target="confirmUnblock">Processing...</span>
            </x-button>
        </div>
    </x-modal>
</div>