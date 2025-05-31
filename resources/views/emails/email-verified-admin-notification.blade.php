{{-- resources/views/emails/email-verified-admin-notification.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Manually Verified - Admin Notification</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 30px 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #ffffff; padding: 30px; border: 1px solid #e1e5e9; border-top: none; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #6c757d; border-radius: 0 0 8px 8px; }
        .info-box { background: #fef3c7; padding: 15px; border-left: 4px solid #f59e0b; margin: 20px 0; border-radius: 4px; }
        .user-details { background: #f8f9fa; padding: 15px; border-radius: 6px; margin: 20px 0; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #f59e0b; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .btn:hover { background-color: #d97706; }
        .verification-details { background: #e0f2fe; padding: 15px; border-left: 4px solid #0284c7; margin: 20px 0; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>📧 Email Manually Verified</h1>
        <p>Administrative Notification</p>
    </div>
    
    <div class="content">
        <p>Hello Administrator,</p>
        
        <p>This is an automated notification to inform you that a user's email address has been manually verified in the system.</p>
        
        <div class="info-box">
            <p><strong>⚠️ Manual Verification Alert:</strong></p>
            <p>This verification was performed manually by an administrator, bypassing the standard email verification process.</p>
        </div>

        <div class="user-details">
            <h3>👤 User Information</h3>
            <p><strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Company:</strong> {{ $user->company->company_name ?? 'N/A' }}</p>
            <p><strong>Role:</strong> {{ $user->role->name ?? 'N/A' }}</p>
            <p><strong>Account Status:</strong> 
                <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; 
                      background-color: {{ $user->status === 'active' ? '#d4edda' : '#f8d7da' }};
                      color: {{ $user->status === 'active' ? '#155724' : '#721c24' }};">
                    {{ ucfirst($user->status) }}
                </span>
            </p>
        </div>
        
        <div class="verification-details">
            <p><strong>🔍 Verification Details:</strong></p>
            <p><strong>Verified by:</strong> {{ $verifiedBy->name }} ({{ $verifiedBy->email }})</p>
            <p><strong>Verification time:</strong> {{ now()->format('F j, Y \a\t g:i A T') }}</p>
            <p><strong>IP Address:</strong> {{ request()->ip() }}</p>
            @if($reason)
                <p><strong>Reason provided:</strong> {{ $reason }}</p>
            @else
                <p><strong>Reason:</strong> <em>No reason provided</em></p>
            @endif
        </div>

        <div class="info-box">
            <p><strong>📋 Recommended Actions:</strong></p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Review the verification to ensure it follows company policies</li>
                <li>Verify that the administrator had proper authorization</li>
                <li>Check if any additional documentation was provided</li>
                <li>Monitor the user's account for any suspicious activity</li>
            </ul>
        </div>

        <div style="text-align: center;">
            <a href="{{ $adminUrl }}" class="btn">View User Management</a>
        </div>

        <p><strong>🔐 Security Note:</strong> Manual email verification should only be performed when alternative verification methods have been used (phone verification, document verification, etc.). If this verification seems unusual, please investigate immediately.</p>
        
        <p>This notification is sent to maintain security and audit compliance.</p>
        
        <p>Best regards,<br>
        <strong>{{ config('app.name') }} System</strong></p>
    </div>
    
    <div class="footer">
        <p>This is an automated administrative notification.</p>
        <p>Security Alert System - {{ config('app.name') }}</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>