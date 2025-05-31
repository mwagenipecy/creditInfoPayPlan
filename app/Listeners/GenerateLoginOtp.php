<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class GenerateLoginOtp
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        
        // Check if user has OTP enabled
        if ($user->otp_enabled ?? true) {
            try {
                // Reset previous OTP verification
                $user->resetOtpVerification();
                
                // Generate new OTP
                $user->generateOtp('login');
                
                Log::info('OTP generated for user login', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'ip' => request()->ip(),
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to generate OTP for user', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}