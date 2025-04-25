
<div>
    <div class="mb-8">
        <!-- Page Header with Back Button -->
        <div class="mb-6 flex items-center">
            <a href="{{ route('document.list') }}" class="mr-3 p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Register New Company</h2>
                <p class="text-sm text-gray-600 mt-1">Add a new company to the verification system</p>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if($successMessage)
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                <p>{{ $successMessage }}</p>
            </div>
        @endif

        @if($errorMessage)
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                <p>{{ $errorMessage }}</p>
            </div>
        @endif

        <!-- Registration Form -->
        <form wire:submit.prevent="saveCompany">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <!-- Company Information Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Company Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Company Name*</label>
                            <input wire:model.blur="company_name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]" placeholder="Enter company legal name">
                            @error('company_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Trading Name (if different)</label>
                            <input wire:model.blur="trading_name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]" placeholder="Enter trading name">
                            @error('trading_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Registration Number*</label>
                            <input wire:model.blur="registration_number" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]" placeholder="Enter registration number">
                            @error('registration_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date of Incorporation*</label>
                            <input wire:model.blur="date_of_incorporation" type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]">
                            @error('date_of_incorporation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Business Type*</label>
                            <select wire:model.blur="business_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]">
                                <option value="">Select business type</option>
                                <option value="sole">Sole Proprietorship</option>
                                <option value="partnership">Partnership</option>
                                <option value="llc">Limited Liability Company</option>
                                <option value="corporation">Corporation</option>
                                <option value="nonprofit">Non-profit</option>
                            </select>
                            @error('business_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Industry*</label>
                            <select wire:model.blur="industry" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]">
                                <option value="">Select industry</option>
                                <option value="agriculture">Agriculture</option>
                                <option value="manufacturing">Manufacturing</option>
                                <option value="retail">Retail</option>
                                <option value="technology">Technology</option>
                                <option value="finance">Finance</option>
                                <option value="education">Education</option>
                                <option value="healthcare">Healthcare</option>
                                <option value="transport">Transportation & Logistics</option>
                                <option value="mining">Mining</option>
                                <option value="construction">Construction</option>
                                <option value="hospitality">Hospitality & Tourism</option>
                                <option value="other">Other</option>
                            </select>
                            @error('industry') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="mb-6 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Contact Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Primary Email*</label>
                            <input wire:model.blur="primary_email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]" placeholder="Enter company email">
                            @error('primary_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number*</label>
                            <input wire:model.blur="phone_number" type="tel" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]" placeholder="Enter phone number">
                            @error('phone_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                            <input wire:model.blur="website" type="url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]" placeholder="Enter company website">
                            @error('website') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Physical Address*</label>
                            <input wire:model.blur="physical_address" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]" placeholder="Enter street address">
                            @error('physical_address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">City/Town*</label>
                            <input wire:model.blur="city" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]" placeholder="Enter city">
                            @error('city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Region*</label>
                            <select wire:model.blur="region" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]">
                                <option value="">Select region</option>
                                <option value="arusha">Arusha</option>
                                <option value="dar">Dar es Salaam</option>
                                <option value="dodoma">Dodoma</option>
                                <option value="geita">Geita</option>
                                <option value="iringa">Iringa</option>
                                <option value="kagera">Kagera</option>
                                <option value="katavi">Katavi</option>
                                <option value="kigoma">Kigoma</option>
                                <option value="kilimanjaro">Kilimanjaro</option>
                                <!-- Add more regions as needed -->
                            </select>
                            @error('region') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Postal Address</label>
                            <input wire:model.blur="postal_address" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]" placeholder="Enter postal address">
                            @error('postal_address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Primary Contact Person Section -->
                <div class="mb-6 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Primary Contact Person</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name*</label>
                            <input wire:model.blur="contact_name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]" placeholder="Enter full name">
                            @error('contact_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Position/Title*</label>
                            <input wire:model.blur="contact_position" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]" placeholder="Enter position/title">
                            @error('contact_position') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email*</label>
                            <input wire:model.blur="contact_email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]" placeholder="Enter email address">
                            @error('contact_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number*</label>
                            <input wire:model.blur="contact_phone" type="tel" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#C40F12]" placeholder="Enter phone number">
                            @error('contact_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('document.list') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-[#C40F12] text-white rounded-lg text-sm font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors">
                        <span wire:loading.remove wire:target="saveCompany">Register Company</span>
                        <span wire:loading wire:target="saveCompany">Registering...</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
