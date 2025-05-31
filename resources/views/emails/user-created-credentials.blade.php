{{-- resources/views/emails/user-created-credentials.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Account Credentials</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; padding: 30px 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #ffffff; padding: 30px; border: 1px solid #e1e5e9; border-top: none; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #6c757d; border-radius: 0 0 8px 8px; }
        .credentials-box { background: #f0f9ff; border: 2px solid #3b82f6; padding: 20px; text-align: center; border-radius: 8px; margin: 20px 0; }
        .password { font-family: 'Courier New', monospace; font-size: 18px; font-weight: bold; color: #1d4ed8; letter-spacing: 2px; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #3b82f6; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .btn:hover { background-color: #1d4ed8; }
        .security-notice { background-color: #fef3c7; padding: 15px; border-left: 4px solid #f59e0b; margin: 20px 0; border-radius: 4px; }
        .info-box { background-color: #e0f2fe; padding: 15px; border-left: 4px solid #0284c7; margin: 20px 0; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 Welcome to {{ config('app.name') }}!</h1>
        <p>Your account has been created</p>
    </div>
    
    <div class="content">
        <p>Hello <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>,</p>
        
        <p>Your account has been created by <strong>{{ $createdBy->name }}</strong>. Below are your login credentials to access {{ config('app.name') }}.</p>
        
        <div class="info-box">
            <p><strong>📋 Account Details:</strong></p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li><strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Company:</strong> {{ $user->company->company_name ?? 'N/A' }}</li>
                <li><strong>Role:</strong> {{ $user->role->display_name ?? 'N/A' }}</li>
                <li><strong>Account Status:</strong> {{ ucfirst($user->status) }}</li>
            </ul>
        </div>

        <div class="credentials-box">
            <h3 style="color: #1d4ed8; margin-top: 0;">🔐 Your Login Credentials</h3>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Password:</strong></p>
            <div class="password">{{ $password }}</div>
            <p style="margin-top: 15px; font-size: 14px; color: #6b7280;">
                Please copy this password and store it securely
            </p>
        </div>

        <div class="security-notice">
            <p><strong>🔒 Important Security Information:</strong></p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li><strong>Change your password immediately</strong> after your first login</li>
                <li>Never share your login credentials with anyone</li>
                <li>Use a strong, unique password that you haven't used elsewhere</li>
                <li>Log out when you're finished using the system</li>
                <li>Contact support if you suspect unauthorized access</li>
            </ul>
        </div>

        <p><strong>🚀 Getting Started:</strong></p>
        <ol style="padding-left: 20px; line-height: 1.8;">
            <li>Click the login button below to access your account</li>
            <li>Use the email and password provided above</li>
            <li>You'll be prompted to change your password on first login</li>
            <li>Complete your profile information if required</li>
            <li>Explore the platform features and tools</li>
        </ol>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $loginUrl }}" class="btn">Login to Your Account</a>
        </div>

        <p>If you have any questions or need assistance getting started, please don't hesitate to contact our support team.</p>
        
        <p>We're excited to have you on board!</p>
        
        <p>Best regards,<br>
        <strong>{{ config('app.name') }} Team</strong></p>
    </div>
    
    <div class="footer">
        <p>This email contains sensitive information. Please do not forward it to others.</p>
        <p>For security reasons, this password should be changed immediately after first login.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>