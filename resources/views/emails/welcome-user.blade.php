{{-- resources/views/emails/welcome-user.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #10b981 0%, #047857 100%); color: white; padding: 30px 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #ffffff; padding: 30px; border: 1px solid #e1e5e9; border-top: none; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #6c757d; border-radius: 0 0 8px 8px; }
        .welcome-badge { background: #d1fae5; border: 2px solid #10b981; padding: 20px; text-align: center; border-radius: 8px; margin: 20px 0; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #10b981; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .btn:hover { background-color: #047857; }
        .feature-box { background-color: #f0f9ff; padding: 15px; border-left: 4px solid #3b82f6; margin: 20px 0; border-radius: 4px; }
        .tips-box { background-color: #fef3c7; padding: 15px; border-left: 4px solid #f59e0b; margin: 20px 0; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 Welcome to {{ config('app.name') }}!</h1>
        <p>We're excited to have you join our community</p>
    </div>
    
    <div class="content">
        <div class="welcome-badge">
            <h2 style="color: #10b981; margin: 0;">Welcome Aboard!</h2>
            <p style="margin: 10px 0 0 0; color: #374151;">You're now part of the {{ config('app.name') }} family</p>
        </div>

        <p>Hello <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>,</p>
        
        <p>Welcome to {{ config('app.name') }}! Your account has been created by <strong>{{ $createdBy->name }}</strong>, and we're thrilled to have you on board.</p>
        
        <div class="feature-box">
            <p><strong>🚀 What you can do with {{ config('app.name') }}:</strong></p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Access comprehensive credit information and reports</li>
                <li>Manage your account and profile settings</li>
                <li>Generate detailed analytics and insights</li>
                <li>Collaborate with your team members</li>
                <li>Get real-time notifications and updates</li>
            </ul>
        </div>

        <p><strong>📧 What's Next?</strong></p>
        <ol style="padding-left: 20px; line-height: 1.8;">
            <li>You'll receive a separate email with your login credentials</li>
            <li>Log in to your account using the provided credentials</li>
            <li>Complete your profile setup and preferences</li>
            <li>Explore the platform features and tools</li>
            <li>Start using the system for your business needs</li>
        </ol>

        <div class="tips-box">
            <p><strong>💡 Getting Started Tips:</strong></p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Take some time to explore the dashboard and main features</li>
                <li>Update your profile information and contact details</li>
                <li>Set up your notification preferences</li>
                <li>Reach out to our support team if you need any assistance</li>
                <li>Check out our documentation and help guides</li>
            </ul>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $loginUrl }}" class="btn">Go to Login Page</a>
        </div>

        <p><strong>🆘 Need Help?</strong></p>
        <p>Our support team is here to help you get the most out of {{ config('app.name') }}. If you have any questions, concerns, or need assistance, please don't hesitate to reach out:</p>
        <ul style="padding-left: 20px;">
            <li>📧 Email: support@{{ config('app.domain', 'example.com') }}</li>
            <li>🌐 Help Center: <a href="{{ $supportUrl }}">{{ $supportUrl }}</a></li>
            <li>📞 Phone: +1 (555) 123-4567</li>
        </ul>

        <p>We're committed to providing you with the best possible experience and look forward to supporting your success.</p>
        
        <p>Once again, welcome to {{ config('app.name') }}!</p>
        
        <p>Best regards,<br>
        <strong>{{ config('app.name') }} Team</strong></p>
    </div>
    
    <div class="footer">
        <p>This is a welcome message for your new {{ config('app.name') }} account.</p>
        <p>If you received this email by mistake, please contact our support team.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>