<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequireOtpVerification
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Skip OTP check for certain routes
        $excludedRoutes = [
            'otp.show',
            'otp.verify',
            'otp.resend',
            'logout',
            'otp.skip', // For development
        ];

        if (in_array($request->route()->getName(), $excludedRoutes)) {
            return $next($request);
        }

        // Check if user needs OTP verification
        if ($user && $user->needsOtpVerification()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'OTP verification required.',
                    'redirect' => route('otp.show'),
                ], 423); // 423 Locked
            }

            return redirect()->route('otp.show');
        }

        return $next($request);
    }
}