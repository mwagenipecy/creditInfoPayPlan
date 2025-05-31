{{-- resources/views/emails/email-verification-confirmation.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Address Verified</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 30px 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #ffffff; padding: 30px; border: 1px solid #e1e5e9; border-top: none; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #6c757d; border-radius: 0 0 8px 8px; }
        .success-badge { background: #d1fae5; border: 2px solid #10b981; padding: 20px; text-align: center; border-radius: 8px; margin: 20px 0; }
        .verified-icon { font-size: 48px; color: #10b981; margin-bottom: 10px; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #10b981; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .btn:hover { background-color: #059669; }
        .info-box { background-color: #f0f9ff; padding: 15px; border-left: 4px solid #3b82f6; margin: 20px 0; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>✅ Email Address Verified!</h1>
        <p>Your email has been successfully verified</p>
    </div>
    
    <div class="content">
        <div class="success-badge">
            <div class="verified-icon">🎉</div>
            <h2 style="color: #10b981; margin: 0;">Verification Complete!</h2>
            <p style="margin: 10px 0 0 0; color: #374151;">Your email address has been verified and your account is now fully active.</p>
        </div>

        <p>Hello <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>,</p>
        
        <p>Great news! Your email address <strong>{{ $user->email }}</strong> has been successfully verified by our team.</p>
        
        <div class="info-box">
            <p><strong>📋 Verification Details:</strong></p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li><strong>Verified by:</strong> {{ $verifiedBy->name }}</li>
                <li><strong>Verification date:</strong> {{ now()->format('F j, Y \a\t g:i A') }}</li>
                @if($reason)
                    <li><strong>Reason:</strong> {{ $reason }}</li>
                @endif
            </ul>
        </div>

        <p><strong>🚀 What this means for you:</strong></p>
        <ul style="padding-left: 20px; line-height: 1.8;">
            <li>✅ Full access to all platform features</li>
            <li>✅ Ability to receive important account notifications</li>
            <li>✅ Enhanced account security</li>
            <li>✅ Complete profile verification</li>
        </ul>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $loginUrl }}" class="btn">Access Your Account</a>
        </div>

        <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
        
        <p>Welcome to {{ config('app.name') }}!</p>
        
        <p>Best regards,<br>
        <strong>{{ config('app.name') }} Team</strong></p>
    </div>
    
    <div class="footer">
        <p>This is an automated message confirming your email verification.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>