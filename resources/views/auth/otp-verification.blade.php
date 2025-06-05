{{-- File: resources/views/auth/otp-verification.blade.php --}}
<x-guest-layout>


@section('guest-section')

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-red-50 to-red-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Verify Your Identity</h2>
                <p class="text-gray-600">
                    We've sent a 6-digit verification code to your 
                    @if($user->phone_number)
                        phone (***{{ substr($user->phone_number, -4) }}) and 
                    @endif
                    email ({{ substr($user->email, 0, 3) }}***{{ substr($user->email, strpos($user->email, '@')) }})
                </p>
            </div>

            <!-- OTP Form -->
            <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
                <form method="POST" action="{{ route('otp.verify') }}" id="otp-form" class="space-y-6">
                    @csrf
                    
                    <!-- OTP Input -->
                    <div>
                        <label for="otp_code" class="block text-sm font-medium text-gray-700 mb-3">
                            Enter 6-digit verification code
                        </label>
                        
                        <!-- OTP Input Fields -->
                        <div class="flex justify-center space-x-3 mb-4">
                            <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500 focus:outline-none transition-colors" data-index="0">
                            <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500 focus:outline-none transition-colors" data-index="1">
                            <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500 focus:outline-none transition-colors" data-index="2">
                            <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500 focus:outline-none transition-colors" data-index="3">
                            <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500 focus:outline-none transition-colors" data-index="4">
                            <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500 focus:outline-none transition-colors" data-index="5">
                        </div>
                        
                        <!-- Hidden input for form submission -->
                        <input type="hidden" name="otp_code" id="otp_code" value="{{ old('otp_code') }}">
                        
                        @error('otp_code')
                            <div class="text-red-600 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                        
                        @error('resend')
                            <div class="text-red-600 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                        
                        @if(session('success'))
                            <div class="text-green-600 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="verify-btn" disabled 
                            class="w-full bg-red-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors disabled:bg-gray-300 disabled:cursor-not-allowed">
                        <span class="verify-text">Verify OTP</span>
                        <span class="loading-text hidden">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Verifying...
                        </span>
                    </button>
                </form>

                <!-- Resend Section -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-3">Didn't receive the code?</p>
                        
                        @if($canResend)
                            <form method="POST" action="{{ route('otp.resend') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-500 font-medium text-sm transition-colors">
                                    Resend OTP
                                </button>
                            </form>
                        @else
                            <p class="text-sm text-gray-500">
                                Resend available in <span id="countdown" class="font-medium">{{ $retryAfter }}s</span>
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Additional Options -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="text-sm text-gray-600 hover:text-gray-500 transition-colors">
                            Sign out
                        </a>
                        
                        @if(!app()->isProduction())
                            <!-- <form method="POST" action="{{ route('otp.skip') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm text-orange-600 hover:text-orange-500 transition-colors">
                                    Skip (Dev Only)
                                </button>
                            </form> -->
                        @endif
                        
                        <div class="text-xs text-gray-500">
                            Code expires in <span id="otp-timer" class="font-medium">10:00</span>
                        </div>
                    </div>
                </div>
                
                <!-- Hidden logout form -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>

            <!-- Security Notice -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-yellow-800">Security Notice</h3>
                        <p class="text-sm text-yellow-700 mt-1">
                            Never share your verification code with anyone. {{ config('app.name') }} will never ask for your OTP via phone or email.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for OTP Input Handling -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');
            const hiddenInput = document.getElementById('otp_code');
            const verifyBtn = document.getElementById('verify-btn');
            const form = document.getElementById('otp-form');
            
            // Auto-focus first input
            otpInputs[0].focus();
            
            // Handle OTP input
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    const value = e.target.value;
                    
                    // Only allow numbers
                    if (!/^\d*$/.test(value)) {
                        e.target.value = '';
                        return;
                    }
                    
                    // Move to next input
                    if (value && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                    
                    updateOtpValue();
                });
                
                input.addEventListener('keydown', function(e) {
                    // Handle backspace
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                    
                    // Handle paste
                    if (e.key === 'v' && (e.ctrlKey || e.metaKey)) {
                        e.preventDefault();
                        navigator.clipboard.readText().then(text => {
                            const numbers = text.replace(/\D/g, '').slice(0, 6);
                            numbers.split('').forEach((digit, i) => {
                                if (otpInputs[i]) {
                                    otpInputs[i].value = digit;
                                }
                            });
                            updateOtpValue();
                            if (numbers.length === 6) {
                                otpInputs[5].focus();
                            }
                        });
                    }
                });
                
                // Handle focus styling
                input.addEventListener('focus', function() {
                    this.classList.add('ring-2', 'ring-red-500');
                });
                
                input.addEventListener('blur', function() {
                    this.classList.remove('ring-2', 'ring-red-500');
                });
            });
            
            function updateOtpValue() {
                const otp = Array.from(otpInputs).map(input => input.value).join('');
                hiddenInput.value = otp;
                
                // Enable/disable submit button
                if (otp.length === 6) {
                    verifyBtn.disabled = false;
                    verifyBtn.classList.remove('disabled:bg-gray-300');
                    verifyBtn.classList.add('bg-red-600', 'hover:bg-red-700');
                } else {
                    verifyBtn.disabled = true;
                    verifyBtn.classList.add('disabled:bg-gray-300');
                    verifyBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
                }
            }
            
            // Handle form submission
            form.addEventListener('submit', function() {
                verifyBtn.disabled = true;
                document.querySelector('.verify-text').classList.add('hidden');
                document.querySelector('.loading-text').classList.remove('hidden');
            });
            
            // Countdown timer for resend
            @if(!$canResend && $retryAfter > 0)
                let countdown = {{ $retryAfter }};
                const countdownElement = document.getElementById('countdown');
                
                const timer = setInterval(() => {
                    countdown--;
                    if (countdownElement) {
                        countdownElement.textContent = countdown + 's';
                    }
                    
                    if (countdown <= 0) {
                        clearInterval(timer);
                        location.reload(); // Refresh to show resend button
                    }
                }, 1000);
            @endif
            
            // OTP expiry timer (10 minutes)
            let otpExpiry = 10 * 60; // 10 minutes in seconds
            const timerElement = document.getElementById('otp-timer');
            
            const otpTimer = setInterval(() => {
                const minutes = Math.floor(otpExpiry / 60);
                const seconds = otpExpiry % 60;
                
                if (timerElement) {
                    timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                }
                
                otpExpiry--;
                
                if (otpExpiry < 0) {
                    clearInterval(otpTimer);
                    if (timerElement) {
                        timerElement.textContent = 'Expired';
                        timerElement.classList.add('text-red-600');
                    }
                    
                    // Disable form
                    otpInputs.forEach(input => input.disabled = true);
                    verifyBtn.disabled = true;
                    verifyBtn.textContent = 'OTP Expired';
                    
                    // Show expired message
                    const expiredDiv = document.createElement('div');
                    expiredDiv.className = 'mt-4 p-4 bg-red-50 border border-red-200 rounded-lg';
                    expiredDiv.innerHTML = `
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-red-800">OTP Expired</h3>
                                <p class="text-sm text-red-700 mt-1">Your verification code has expired. Please request a new one.</p>
                            </div>
                        </div>
                    `;
                    form.appendChild(expiredDiv);
                }
            }, 1000);
            
            // Auto-submit when all 6 digits are entered
            function checkAutoSubmit() {
                const otp = hiddenInput.value;
                if (otp.length === 6) {
                    setTimeout(() => {
                        if (hiddenInput.value.length === 6) { // Double-check
                            form.submit();
                        }
                    }, 500); // Small delay for better UX
                }
            }
            
            // Add auto-submit listener
            hiddenInput.addEventListener('change', checkAutoSubmit);
            
            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Clear all inputs with Escape
                if (e.key === 'Escape') {
                    otpInputs.forEach(input => input.value = '');
                    hiddenInput.value = '';
                    otpInputs[0].focus();
                    updateOtpValue();
                }
                
                // Submit with Enter (if OTP is complete)
                if (e.key === 'Enter' && hiddenInput.value.length === 6) {
                    form.submit();
                }
            });
        });
    </script>

    <style>
        /* Additional styling for better UX */
        .otp-input:focus {
            transform: scale(1.05);
        }
        
        .otp-input.error {
            border-color: #ef4444;
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 20%, 40%, 60%, 80% { transform: translateX(-5px); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(5px); }
            100% { transform: translateX(0); }
        }
        
        /* Loading animation */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Smooth transitions */
        .otp-input {
            transition: all 0.2s ease-in-out;
        }
        
        .otp-input:hover {
            border-color: #6366f1;
        }
        
        /* Mobile responsiveness */
        @media (max-width: 640px) {
            .otp-input {
                width: 2.5rem;
                height: 2.5rem;
                font-size: 1rem;
            }
        }
    </style>

@endsection

</x-guest-layout>
