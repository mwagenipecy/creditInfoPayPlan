{{-- resources/views/emails/user-unblocked-notification.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Access Restored</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg,rgb(185, 27, 16) 0%, #059669 100%); color: white; padding: 30px 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #ffffff; padding: 30px; border: 1px solid #e1e5e9; border-top: none; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #6c757d; border-radius: 0 0 8px 8px; }
        .success-badge { background: #d1fae5; border: 2px solid #10b981; padding: 20px; text-align: center; border-radius: 8px; margin: 20px 0; }
        .restored-icon { font-size: 48px; color:rgb(227, 41, 27); margin-bottom: 10px; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #10b981; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .btn:hover { background-color:rgb(218, 30, 30); }
        .info-box { background-color: #e0f2fe; padding: 15px; border-left: 4px solid #0284c7; margin: 20px 0; border-radius: 4px; }
        .guidelines-box { background-color: #fef3c7; padding: 15px; border-left: 4px solid #f59e0b; margin: 20px 0; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 Account Access Restored!</h1>
        <p>Welcome back to {{ config('app.name') }}</p>
    </div>
    
    <div class="content">
        <div class="success-badge">
            <div class="restored-icon">🔓</div>
            <h2 style="color: #10b981; margin: 0;">Access Restored!</h2>
            <p style="margin: 10px 0 0 0; color: #374151;">Your account has been unblocked and you can now access all features.</p>
        </div>

        <p>Hello <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>,</p>
        
        <p>We're pleased to inform you that your account access has been restored and you can now fully use {{ config('app.name') }}.</p>
        
        <div class="info-box">
            <p><strong>📋 Unblock Details:</strong></p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li><strong>Unblocked by:</strong> {{ $unblockedBy->name }}</li>
                <li><strong>Date restored:</strong> {{ now()->format('F j, Y \a\t g:i A') }}</li>
                @if($reason)
                    <li><strong>Reason:</strong> {{ $reason }}</li>
                @endif
            </ul>
        </div>

        <p><strong>🚀 What you can do now:</strong></p>
        <ul style="padding-left: 20px; line-height: 1.8;">
            <li>✅ Log in to your account</li>
            <li>✅ Access all platform features</li>
            <li>✅ Continue with your normal activities</li>
            <li>✅ Receive important notifications</li>
        </ul>

        <div class="guidelines-box">
            <p><strong>📝 Important Reminders:</strong></p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Please ensure you follow all platform guidelines</li>
                <li>Review our terms of service and acceptable use policy</li>
                <li>Contact support if you have any questions</li>
                <li>Report any issues or concerns promptly</li>
            </ul>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $loginUrl }}" class="btn">Access Your Account</a>
        </div>

        <p>We appreciate your understanding and look forward to your continued use of our platform. If you have any questions or concerns, please don't hesitate to reach out to our support team.</p>
        
        <p>Thank you for being part of the {{ config('app.name') }} community!</p>
        
        <p>Best regards,<br>
        <strong>{{ config('app.name') }} Team</strong></p>
    </div>
    
    <div class="footer">
        <p>This is an automated message confirming your account restoration.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>