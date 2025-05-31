<?php

namespace App\Mail;

use App\Models\UserOtp;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public UserOtp $otp;

    public function __construct(UserOtp $otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Your OTP Code - ' . config('app.name'))
                    ->view('emails.otp')
                    ->with([
                        'otpCode' => $this->otp->otp_code,
                        'expiresAt' => $this->otp->expires_at,
                        'userName' => $this->otp->user->name,
                    ]);
    }
}