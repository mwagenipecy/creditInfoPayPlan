{{-- resources/views/livewire/user-management/actions/unblock-user.blade.php --}}
<div>
    @if($showModal && $user)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <!-- Modal Header -->
                <div class="px-6 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium">Unblock User</h3>
                            <p class="text-red-100 text-sm">Restore user access to the system</p>
                        </div>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="px-6 py-4">
                    <!-- User Information -->
                    <div class="mb-6 bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">User Information</h4>
                        <div class="flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->first_name . '+' . $user->last_name) }}&background=EF4444&color=ffffff&bold=true&size=48" 
                                 class="h-12 w-12 rounded-full" 
                                 alt="{{ $user->name }}">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                <p class="text-xs text-gray-500">{{ $user->company->company_name ?? 'No Company' }} • {{ $user->role->name ?? 'No Role' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Current Status & Block Information -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Current Status</h4>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>
                            
                            @if($this->blockInfo)
                                <div class="text-sm text-red-800 space-y-1">
                                    @if($this->blockInfo['blocked_at'])
                                        <p><strong>Blocked:</strong> {{ $this->blockInfo['blocked_at']->format('M j, Y g:i A') }} ({{ $this->blockInfo['days_blocked'] }} days ago)</p>
                                    @endif
                                    <p><strong>Blocked by:</strong> {{ $this->blockInfo['blocked_by'] }}</p>
                                    @if($this->blockInfo['block_reason'])
                                        <p><strong>Reason:</strong> {{ $this->blockInfo['block_reason'] }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Company Block Warning -->
                    @if($this->isCompanyBlocked)
                        <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex">
                                <svg class="flex-shrink-0 h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Company Access Restriction</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>This user belongs to <strong>{{ $user->company->company_name }}</strong>, which is currently blocked.</p>
                                        <p class="mt-1">While you can unblock this user, they will still be unable to access the system until the company is unblocked as well.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Unblock Reason -->
                    <div class="mb-6">
                        <label for="unblock_reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Reason for Unblocking <span class="text-red-500">*</span>
                        </label>
                        <textarea id="unblock_reason" 
                                  wire:model="unblockReason" 
                                  rows="4" 
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                  placeholder="Please provide a detailed reason for unblocking this user (e.g., issue resolved, appeal approved, etc.)"></textarea>
                        @error('unblockReason')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notification Options -->
                    <div class="mb-6 space-y-4">
                        <h4 class="text-sm font-medium text-gray-900">Notification Settings</h4>
                        
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" 
                                       id="send_notification" 
                                       wire:model="sendNotification" 
                                       class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                            </div>
                            <div class="ml-3">
                                <label for="send_notification" class="text-sm font-medium text-gray-700">
                                    Notify user via email
                                </label>
                                <p class="text-xs text-gray-500">
                                    Send an email to the user informing them that their account has been unblocked.
                                </p>
                            </div>
                        </div>
                        
                        @if(!auth()->user()->hasRole('super_admin'))
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" 
                                       id="notify_admins" 
                                       wire:model="notifyAdmins" 
                                       class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                            </div>
                            <div class="ml-3">
                                <label for="notify_admins" class="text-sm font-medium text-gray-700">
                                    Notify administrators
                                </label>
                                <p class="text-xs text-gray-500">
                                    Send notification to super administrators about this unblock action.
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Confirmation Message -->
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="flex-shrink-0 h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Confirm Unblock Action</h3>
                                <p class="text-sm text-red-700 mt-1">
                                    Are you sure you want to unblock <strong>{{ $user->name }}</strong>? This will restore their full access to the system.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row-reverse sm:space-x-reverse sm:space-x-3 space-y-3 sm:space-y-0">
                    <button type="button" 
                            wire:click="confirmUnblock" 
                            wire:loading.attr="disabled"
                            class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50">
                        <span wire:loading.remove wire:target="confirmUnblock">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Unblock User
                        </span>
                        <span wire:loading wire:target="confirmUnblock" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                    
                    <button type="button" 
                            wire:click="closeModal" 
                            class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>