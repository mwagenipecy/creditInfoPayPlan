<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'role_id',
        'email_verified_at',
        'status',
        'company_id',
        'otp_verified',
        'otp_verified_at',
        'otp_enabled',
        'phone_number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    public function accessRequests()
    {
        return $this->hasMany(AccessRequest::class, 'requester_id');
    }

    /**
     * Get the access requests approved by this user.
     */
    public function approvedRequests()
    {
        return $this->hasMany(AccessRequest::class, 'approved_by');
    }


    public function isAdmin()
{
    return $this->role_id === 'admin';
}


public function isCompany()
{
    return $this->role_id === 'company';
}


public function hasRole(){

    return $this->belongsTo(Role::class);
}


public function role(){

    return $this->belongsTo(Role::class,'role_id');
}


public function company(){

    return $this->belongsTo(Company::class,'company_id');
}



public function otps()
{
    return $this->hasMany(UserOtp::class);
}

// Generate and send OTP
public function generateOtp(string $purpose = 'login'): UserOtp
{
    // Invalidate existing OTPs for this purpose
    $this->otps()
        ->where('purpose', $purpose)
        ->where('is_used', false)
        ->update(['is_used' => true]);

    // Create new OTP
    $otp = $this->otps()->create([
        'otp_code' => UserOtp::generateCode(),
        'purpose' => $purpose,
        'expires_at' => now()->addMinutes(10), // 10 minutes expiry
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);

    // Send OTP via SMS/Email
    $this->sendOtp($otp);

    return $otp;
}

// Send OTP notification
private function sendOtp(UserOtp $otp): void
{
    // Send via SMS if phone number exists
    if ($this->phone_number) {
        // Implement SMS sending logic here
        // Example: SMS::send($this->phone_number, "Your OTP is: {$otp->otp_code}");
    }

    // Always send via email as backup
    \Mail::to($this->email)->send(new \App\Mail\OtpMail($otp));
}

// Verify OTP
public function verifyOtp(string $otpCode, string $purpose = 'login'): bool
{
    $otp = $this->otps()
        ->where('otp_code', $otpCode)
        ->where('purpose', $purpose)
        ->where('is_used', false)
        ->where('expires_at', '>', now())
        ->first();

    if ($otp) {
        $otp->markAsUsed();
        
        if ($purpose === 'login') {
            $this->update([
                'otp_verified' => true,
                'otp_verified_at' => now(),
            ]);
        }
        
        return true;
    }

    return false;
}

// Check if user needs OTP verification
public function needsOtpVerification(): bool
{
    return $this->otp_enabled && !$this->otp_verified;
}

// Reset OTP verification status (call this on logout)
public function resetOtpVerification(): void
{
    $this->update([
        'otp_verified' => false,
        'otp_verified_at' => null,
    ]);
}




}
