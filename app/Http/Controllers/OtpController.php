<?php

namespace App\Http\Controllers;

use App\Models\UserOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class OtpController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        // Redirect if OTP not needed
        if (!$user->needsOtpVerification()) {
            return redirect()->route('dashboard');
        }

        return view('auth.otp-verification', [
            'user' => $user,
            'canResend' => !RateLimiter::tooManyAttempts('otp-resend:' . $user->id, 3),
            'retryAfter' => RateLimiter::availableIn('otp-resend:' . $user->id),
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp_code' => ['required', 'string', 'size:6', 'regex:/^[0-9]+$/'],
        ]);

        $user = Auth::user();
        $key = 'otp-verify:' . $user->id;

        // Rate limiting
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'otp_code' => ['Too many attempts. Please try again in ' . RateLimiter::availableIn($key) . ' seconds.'],
            ]);
        }

        // Verify OTP
        if ($user->verifyOtp($request->otp_code)) {
            RateLimiter::clear($key);
            
            session()->flash('success', 'OTP verified successfully!');
            return redirect()->intended(route('dashboard'));
        }

        RateLimiter::hit($key, 300); // 5 minutes lockout

        throw ValidationException::withMessages([
            'otp_code' => ['Invalid or expired OTP code.'],
        ]);
    }

    public function resend(Request $request)
    {
        $user = Auth::user();
        $key = 'otp-resend:' . $user->id;

        // Rate limiting for resend
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->withErrors([
                'resend' => 'Too many resend attempts. Please wait ' . RateLimiter::availableIn($key) . ' seconds.',
            ]);
        }

        try {
            $user->generateOtp('login');
            RateLimiter::hit($key, 300); // 5 minutes between resends

            return back()->with('success', 'OTP has been resent to your email/phone.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'resend' => 'Failed to send OTP. Please try again.',
            ]);
        }
    }

    public function skip(Request $request)
    {
        // Only allow skipping in development or for specific users
        if (!app()->isProduction() || Auth::user()->hasRole('developer')) {
            Auth::user()->update([
                'otp_verified' => true,
                'otp_verified_at' => now(),
            ]);
            
            return redirect()->route('dashboard');
        }

        abort(403, 'OTP verification cannot be skipped.');
    }
}