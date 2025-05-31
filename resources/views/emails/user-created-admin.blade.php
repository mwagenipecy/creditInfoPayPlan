{{-- resources/views/emails/user-created-admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Created - Admin Notification</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%); color: white; padding: 30px 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #ffffff; padding: 30px; border: 1px solid #e1e5e9; border-top: none; }
        .footer { background: #f8f9fa; padding: 20px; text-center; font-size: 12px; color: #6c757d; border-radius: 0 0 8px 8px; }
        .info-box { background: #f3e8ff; padding: 15px; border-left: 4px solid #7c3aed; margin: 20px 0; border-radius: 4px; }
        .user-details { background: #f8f9fa; padding: 15px; border-radius: 6px; margin: 20px 0; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #7c3aed; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .btn:hover { background-color: #5b21b6; }
        .creation-details { background: #e0f2fe; padding: 15px; border-left: 4px solid #0284c7; margin: 20px 0; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>👤 New User Created</h1>
        <p>Administrative Notification</p>
    </div>
    
    <div class="content">
        <p>Hello Administrator,</p>
        
        <p>This is an automated notification to inform you that a new user account has been created in the system.</p>
        
        <div class="info-box">
            <p><strong>📝 New User Alert:</strong></p>
            <p>A new user has been added to the system by {{ $createdBy->name }}. Please review the user details below and ensure appropriate access permissions are in place.</p>
        </div>

        <div class="user-details">
            <h3>👤 New User Information</h3>
            <p><strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Company:</strong> {{ $user->company->company_name ?? 'N/A' }}</p>
            <p><strong>Role:</strong> {{ $user->role->display_name ?? 'N/A' }}</p>
            <p><strong>Initial Status:</strong> 
                <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; 
                      background-color: {{ $user->status === 'active' ? '#d4edda' : ($user->status === 'pending' ? '#fff3cd' : '#f8d7da') }};
                      color: {{ $user->status === 'active' ? '#155724' : ($user->status === 'pending' ? '#856404' : '#721c24') }};">
                    {{ ucfirst($user->status) }}
                </span>
            </p>
        </div>
        
        <div class="creation-details">
            <p><strong>📋 Creation Details:</strong></p>
            <p><strong>Created by:</strong> {{ $createdBy->name }} ({{ $createdBy->email }})</p>
            <p><strong>Created on:</strong> {{ now()->format('F j, Y \a\t g:i A T') }}</p>
            <p><strong>IP Address:</strong> {{ request()->ip() }}</p>
            <p><strong>User Agent:</strong> {{ request()->userAgent() }}</p>
        </div>

        <div class="info-box">
            <p><strong>📋 Recommended Actions:</strong></p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Review the user's role and permissions</li>
                <li>Verify that the user should have access to the assigned company</li>
                <li>Check if any additional training or onboarding is needed</li>
                <li>Monitor the user's initial activity and access patterns</li>
                <li>Ensure the user has received their welcome and credentials emails</li>
            </ul>
        </div>

        @if($user->status === 'pending')
            <div class="info-box" style="background: #fff3cd; border-color: #f59e0b;">
                <p><strong>⏳ Action Required:</strong></p>
                <p>This user account is in <strong>pending</strong> status and will require approval before the user can access the system. Please review and approve the account when appropriate.</p>
            </div>
        @endif

        <div style="text-align: center;">
            <a href="{{ $adminUrl }}" class="btn">View User Management</a>
        </div>

        <p><strong>🔐 Security Note:</strong> New user creation activities are logged for security and audit purposes. If this user creation seems unusual or unauthorized, please investigate immediately.</p>
        
        <p>This notification helps maintain oversight and security compliance for user account management.</p>
        
        <p>Best regards,<br>
        <strong>{{ config('app.name') }} System</strong></p>
    </div>
    
    <div class="footer">
        <p>This is an automated administrative notification.</p>
        <p>User Management System - {{ config('app.name') }}</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>