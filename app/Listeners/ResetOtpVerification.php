<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ResetOtpVerification
{
    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        if ($event->user) {
            try {
                $event->user->resetOtpVerification();
                
                Log::info('OTP verification reset on logout', [
                    'user_id' => $event->user->id,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to reset OTP verification', [
                    'user_id' => $event->user->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}