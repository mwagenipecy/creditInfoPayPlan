
{{-- File: resources/views/emails/otp.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your OTP Code</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; background: linear-gradient(135deg,rgb(239, 41, 37) 0%,rgb(235, 36, 36) 100%); color: white; padding: 30px; border-radius: 10px 10px 0 0; }
        .content { background: #f8f9fa; padding: 30px; }
        .otp-code { background: #fff; border: 2px dashedrgb(240, 58, 38); padding: 20px; text-align: center; margin: 20px 0; border-radius: 10px; }
        .otp-number { font-size: 36px; font-weight: bold; color:rgb(233, 61, 38); letter-spacing: 8px; font-family: 'Courier New', monospace; }
        .footer { background: #e9ecef; padding: 20px; text-align: center; font-size: 14px; color: #6c757d; border-radius: 0 0 10px 10px; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .btn { display: inline-block; background:rgb(242, 55, 22); color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
            <p>Your verification code is ready</p>
        </div>
        
        <div class="content">
            <h2>Hello {{ $userName }}!</h2>
            
            <p>You requested a verification code to access your account. Use the code below to complete your login:</p>
            
            <div class="otp-code">
                <div class="otp-number">{{ $otpCode }}</div>
                <p style="margin: 10px 0 0 0; color: #6c757d; font-size: 14px;">This code expires at {{ $expiresAt->format('M j, Y g:i A') }}</p>
            </div>
            
            <div class="warning">
                <strong>⚠️ Security Notice:</strong>
                <ul style="margin: 10px 0 0 20px;">
                    <li>Never share this code with anyone</li>
                    <li>{{ config('app.name') }} will never ask for your OTP via phone or email</li>
                    <li>If you didn't request this code, please ignore this email</li>
                </ul>
            </div>
            
            <p>If you're having trouble with the verification process, please contact our support team.</p>
            
            <a href="mailto:support@{{ parse_url(config('app.url'), PHP_URL_HOST) }}" class="btn">Contact Support</a>
        </div>
        
        <div class="footer">
            <p>This email was sent from {{ config('app.name') }}</p>
            <p>{{ config('app.url') }}</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>