{{-- resources/views/emails/user-status-changed-admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User {{ ucfirst($action) }} - Admin Notification</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, {{ $action === 'unblocked' ? '#10b981 0%, #059669 100%' : '#ef4444 0%, #dc2626 100%' }}); color: white; padding: 30px 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #ffffff; padding: 30px; border: 1px solid #e1e5e9; border-top: none; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #6c757d; border-radius: 0 0 8px 8px; }
        .info-box { background: {{ $action === 'unblocked' ? '#d1fae5' : '#fecaca' }}; padding: 15px; border-left: 4px solid {{ $action === 'unblocked' ? '#10b981' : '#ef4444' }}; margin: 20px 0; border-radius: 4px; }
        .user-details { background: #f8f9fa; padding: 15px; border-radius: 6px; margin: 20px 0; }
        .btn { display: inline-block; padding: 12px 24px; background-color: {{ $action === 'unblocked' ? '#10b981' : '#ef4444' }}; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .btn:hover { background-color: {{ $action === 'unblocked' ? '#059669' : '#dc2626' }}; }
        .action-details { background: #e0f2fe; padding: 15px; border-left: 4px solid #0284c7; margin: 20px 0; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $action === 'unblocked' ? '🔓' : '🔒' }} User {{ ucfirst($action) }}</h1>
        <p>Administrative Notification</p>
    </div>
    
    <div class="content">
        <p>Hello Administrator,</p>
        
        <p>This is an automated notification to inform you that a user account has been <strong>{{ $action }}</strong> in the system.</p>
        
        <div class="info-box">
            <p><strong>{{ $action === 'unblocked' ? '🔓' : '🔒' }} Action Summary:</strong></p>
            <p>A user account has been <strong>{{ $action }}</strong> by {{ $changedBy->name }}. Please review the details below and take any necessary follow-up actions.</p>
        </div>

        <div class="user-details">
            <h3>👤 User Information</h3>
            <p><strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Company:</strong> {{ $user->company->company_name ?? 'N/A' }}</p>
            <p><strong>Role:</strong> {{ $user->role->name ?? 'N/A' }}</p>
            <p><strong>Current Status:</strong> 
                <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; 
                      background-color: {{ $user->status === 'active' ? '#d4edda' : '#f8d7da' }};
                      color: {{ $user->status === 'active' ? '#155724' : '#721c24' }};">
                    {{ ucfirst($user->status) }}
                </span>
            </p>
        </div>
        
        <div class="action-details">
            <p><strong>📝 Action Details:</strong></p>
            <p><strong>{{ ucfirst($action) }} by:</strong> {{ $changedBy->name }} ({{ $changedBy->email }})</p>
            <p><strong>{{ ucfirst($action) }} on:</strong> {{ now()->format('F j, Y \a\t g:i A T') }}</p>
            <p><strong>IP Address:</strong> {{ request()->ip() }}</p>
            @if($reason)
                <p><strong>Reason provided:</strong> {{ $reason }}</p>
            @else
                <p><strong>Reason:</strong> <em>No reason provided</em></p>
            @endif
        </div>

        @if($action === 'unblocked')
            <div class="info-box">
                <p><strong>✅ Post-Unblock Checklist:</strong></p>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Verify the unblock reason is appropriate and documented</li>
                    <li>Check if any additional access restrictions should be applied</li>
                    <li>Monitor user activity for any unusual behavior</li>
                    <li>Ensure the user understands platform guidelines</li>
                </ul>
            </div>
        @else
            <div class="info-box">
                <p><strong>🔒 Post-Block Review:</strong></p>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Review the block reason and ensure it's appropriate</li>
                    <li>Verify that proper procedures were followed</li>
                    <li>Check if any additional security measures are needed</li>
                    <li>Document the incident for future reference</li>
                </ul>
            </div>
        @endif

        <div style="text-align: center;">
            <a href="{{ $adminUrl }}" class="btn">View User Management</a>
        </div>

        <p>This notification is sent to maintain security and audit compliance. If you have any concerns about this action, please investigate immediately.</p>
        
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