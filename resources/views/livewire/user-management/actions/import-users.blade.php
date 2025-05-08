<div>
    <x-modal wire:model="showModal" max-width="lg">
        <div class="px-6 py-4">
            <!-- Modal Header -->
            <div class="text-lg font-medium text-gray-900 flex items-center">
                <svg class="mr-2 h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                <span>Import Users</span>
            </div>

            @if(!$processComplete)
                <!-- Instructions -->
                <div class="mt-6 space-y-6">
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">CSV Format Instructions</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <p>Your CSV should include the following columns:</p>
                                    <ul class="list-disc list-inside mt-1 ml-2">
                                        <li>first_name (required)</li>
                                        <li>last_name (required)</li>
                                        <li>email (required, must be unique)</li>
                                        <li>password (optional, will be generated if not provided)</li>
                                    </ul>
                                    <p class="mt-2">
                                        <a href="#" class="text-blue-600 underline font-medium" wire:click.prevent="downloadSampleCsv">
                                            Download sample CSV template
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div>
                        <x-label for="csvFile" value="CSV File" />
                        <div
                            x-data="{ isUploading: false, progress: 0 }"
                            x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                        >
                            <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="file-upload" type="file" class="sr-only" wire:model="csvFile">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">CSV up to 10MB</p>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div x-show="isUploading" class="mt-2">
                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-indigo-600 rounded-full" :style="`width: ${progress}%`"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1 text-center" x-text="`Uploading: ${progress}%`"></p>
                            </div>

                            @error('csvFile') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Default Settings -->
                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Default Settings for Imported Users</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Company -->
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

                            <!-- Role -->
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
                        </div>

                        <!-- Notify Users -->
                        <div class="flex items-center mt-4">
                            <input id="notifyUsers" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" wire:model.defer="notifyUsers">
                            <label for="notifyUsers" class="ml-2 block text-sm text-gray-700">
                                Send welcome email to all imported users
                            </label>
                        </div>
                    </div>
                </div>
            @else
                <!-- Import Results -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Import Results</h3>

                    <div class="flex items-center mb-6">
                        <!-- Success Count -->
                        <div class="flex items-center mr-6">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-700">Success</span>
                                <span class="block text-xl font-bold text-gray-900">{{ count(array_filter($importResults, fn($r) => $r['status'] === 'success')) }}</span>
                            </div>
                        </div>

                        <!-- Error Count -->
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-700">Errors</span>
                                <span class="block text-xl font-bold text-gray-900">{{ count(array_filter($importResults, fn($r) => $r['status'] === 'error')) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Results Table -->
                    <div class="overflow-x-auto border border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Row</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Message</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($importResults as $index => $result)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $result['email'] ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm {{ $result['status'] === 'success' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ ucfirst($result['status']) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $result['message'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </x-modal>
</div>
