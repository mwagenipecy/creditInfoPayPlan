<div>
    @if($showModal)
    <!-- Modal Background Overlay -->
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal Panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <!-- Modal Header -->
                <div class="px-6 py-4">
                    <div class="text-lg font-medium text-gray-900 flex items-center">
                        <svg class="mr-2 h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                        <span>Block User</span>
                    </div>
                    
                    <div class="mt-4">
                        <p class="text-sm text-gray-600 mb-4">
                            You are about to block <strong>{{ $user->name ?? '' }}</strong>. 
                            This user will no longer be able to log in or access the system until they are unblocked.
                        </p>
                        
                        <!-- Block Reason -->
                        <div class="mb-4">
                            <label for="blockReason" class="block text-sm font-medium text-gray-700">Reason for Blocking</label>
                            <textarea id="blockReason" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50" 
                                wire:model.defer="blockReason" 
                                placeholder="Please provide a reason for blocking this user..."></textarea>
                            @error('blockReason') 
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 text-right">
                    <!-- Cancel Button -->
                    <button type="button" 
                        class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-2" 
                        wire:click="closeModal">
                        Cancel
                    </button>
                    
                    <!-- Block Button -->
                    <button type="button" 
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" 
                        wire:click="confirmBlock" 
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="confirmBlock">Block User</span>
                        <span wire:loading wire:target="confirmBlock">Processing...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>