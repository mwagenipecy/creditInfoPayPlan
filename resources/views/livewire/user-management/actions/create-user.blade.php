{{-- resources/views/livewire/user-management/actions/create-user.blade.php --}}
<div>
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <!-- Modal Header -->
                <div class="px-6 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium">Create New User</h3>
                            <p class="text-red-100 text-sm">Add a new user to the system</p>
                        </div>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="px-6 py-4 max-h-96 overflow-y-auto">
                    <div class="space-y-6">
                        <!-- Personal Information Section -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                Personal Information
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- First Name -->
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        First Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="first_name" 
                                           wire:model="first_name" 
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                           placeholder="Enter first name">
                                    @error('first_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Last Name -->
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Last Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="last_name" 
                                           wire:model="last_name" 
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                           placeholder="Enter last name">
                                    @error('last_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div class="mt-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       wire:model="email" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                       placeholder="Enter email address">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Account Configuration Section -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                </svg>
                                Account Configuration
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Company Selection - Only for Super Admin -->
                               
                                @if(auth()->user()->role->name=='super_admin')
                                <div>
                                    <label for="company_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        Company <span class="text-red-500">*</span>
                                    </label>
                                    <select id="company_id" 
                                            wire:model="company_id" 
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                            
                                            >
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('company_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                @else
                                    <input type="hidden" wire:model="company_id">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                                        <div class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-sm text-gray-700">
                                            {{ $companies->first()->company_name ?? 'Your Company' }}
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Role Selection -->
                                <div>
                                    <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        Role <span class="text-red-500">*</span>
                                    </label>
                                    <select id="role_id" 
                                            wire:model="role_id" 
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                            
                                            >
                                        <option value="">Select Role</option>
                                        @foreach($roles as $role)
                                          @if(auth()->user()->role->name!='super_admin')

                                           @if($role->id==1)

                                           @continue

                                             @endif

                                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>

                                            @else

                                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>


                                            @endif 
                                            
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Status Selection -->
                            <div class="mt-4">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                    Initial Status
                                </label>
                                <select id="status" 
                                        wire:model="status" 
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                                    <option value="active">Active - User can log in immediately</option>
                                    <option value="inactive">Inactive - User cannot log in</option>
                                    <option value="pending">Pending - Awaiting approval</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Information -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                                Security
                            </h4>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="flex-shrink-0 h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800">Automatic Password Generation</h3>
                                        <p class="text-sm text-green-700 mt-1">
                                            A secure password will be automatically generated for this user. The password will be sent to the user via email and will not be visible in the system interface.
                                        </p>
                                        <ul class="mt-2 text-xs text-green-600 list-disc list-inside">
                                            <li>12+ characters with mixed case, numbers, and symbols</li>
                                            <li>Meets all security requirements</li>
                                            <li>User will be prompted to change on first login</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notification Options -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                                Email Notifications
                            </h4>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" 
                                               id="send_welcome_email" 
                                               wire:model="send_welcome_email" 
                                               class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                                    </div>
                                    <div class="ml-3">
                                        <label for="send_welcome_email" class="text-sm font-medium text-gray-700">
                                            Send welcome email
                                        </label>
                                        <p class="text-xs text-gray-500">
                                            Send a welcome message with platform information and getting started guide.
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" 
                                               id="send_credentials_email" 
                                               wire:model="send_credentials_email" 
                                               class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                                    </div>
                                    <div class="ml-3">
                                        <label for="send_credentials_email" class="text-sm font-medium text-gray-700">
                                            Send login credentials
                                        </label>
                                        <p class="text-xs text-gray-500">
                                            Send the generated password and login instructions to the user.
                                        </p>
                                    </div>
                                </div>
                                
                                @if(!auth()->user()->hasRole('super_admin'))
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" 
                                               id="notify_admins" 
                                               wire:model="notify_admins" 
                                               class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                                    </div>
                                    <div class="ml-3">
                                        <label for="notify_admins" class="text-sm font-medium text-gray-700">
                                            Notify administrators
                                        </label>
                                        <p class="text-xs text-gray-500">
                                            Send notification to super administrators about this new user.
                                        </p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row-reverse sm:space-x-reverse sm:space-x-3 space-y-3 sm:space-y-0">
                    <button type="button" 
                            wire:click="createUser" 
                            wire:loading.attr="disabled"
                            class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50">
                        <span wire:loading.remove wire:target="createUser">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                            </svg>
                            Create User
                        </span>
                        <span wire:loading wire:target="createUser" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Creating User...
                        </span>
                    </button>
                    
                    <button type="button" 
                            wire:click="closeModal" 
                            class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>