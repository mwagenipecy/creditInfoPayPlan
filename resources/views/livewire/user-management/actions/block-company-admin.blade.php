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
                    <div class="text-lg font-medium text-red-600 flex items-center">
                        <svg class="mr-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>Block Company Admin</span>
                    </div>
                    
                    <div class="mt-4">
                        <div class="bg-red-50 p-4 rounded-lg border border-red-100 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Warning: This action has company-wide impact</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p>You are about to block <strong>{{ $admin->name ?? '' }}</strong> who is an admin of <strong>{{ $company->name ?? '' }}</strong>.</p>
                                        <p class="mt-1">This will block <strong>all {{ $userCount }} users</strong> in this company and prevent them from accessing the system.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Block Reason -->
                        <div class="mb-4">
                            <label for="blockReason" class="block text-sm font-medium text-gray-700">Reason for Blocking</label>
                            <textarea id="blockReason" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50" 
                                wire:model.defer="blockReason" 
                                placeholder="Please provide a detailed reason for blocking this company admin and all associated users..."></textarea>
                            @error('blockReason') 
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span> 
                            @enderror
                        </div>
                        
                        <!-- Confirmation Phrase -->
                        <div class="mb-4">
                            <label for="confirmationPhrase" class="block text-sm font-medium text-gray-700">Confirmation</label>
                            <p class="text-sm text-gray-600 mb-2">To confirm this action, please type "BLOCK COMPANY" in the field below:</p>
                            <input id="confirmationPhrase" 
                                type="text" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50" 
                                wire:model.defer="confirmationPhrase" 
                                placeholder="BLOCK COMPANY" />
                            @error('confirmationPhrase') 
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
                        <span wire:loading.remove wire:target="confirmBlock">Block Company</span>
                        <span wire:loading wire:target="confirmBlock">Processing...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>