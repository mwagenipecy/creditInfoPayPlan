<div>
    <x-modal wire:model="showModal" max-width="md">
        <div class="px-6 py-4">
            <div class="text-lg font-medium text-gray-900 flex items-center">
                <svg class="mr-2 h-6 w-6 text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>Verify User Email</span>
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
                            <h3 class="text-sm font-medium text-blue-800">Manual Verification</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>You are about to manually verify the email address for <strong>{{ $user->email ?? '' }}</strong>.</p>
                                <p class="mt-1">This will mark the user's email as verified without requiring them to click a verification link.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <p class="text-sm text-gray-600 mb-4">
                    Do you want to manually verify the email address for <strong>{{ $user->name ?? '' }}</strong>?
                </p>
                
                <!-- Send Notification Option -->
                <div class="flex items-center mt-4">
                    <input id="sendNotification" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" wire:model.defer="sendNotification">
                    <label for="sendNotification" class="ml-2 block text-sm text-gray-700">
                        Send notification email to user about this verification
                    </label>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 text-right">
            <x-secondary-button wire:click="closeModal" class="mr-2">
                Cancel
            </x-secondary-button>
            
            <x-button wire:click="confirmVerification" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="confirmVerification">Verify Email</span>
                <span wire:loading wire:target="confirmVerification">Processing...</span>
            </x-button>
        </div>
    </x-modal>
</div>