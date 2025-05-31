{{-- resources/views/emails/user-updated-admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account Updated - Admin Notification</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 30px 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #ffffff; padding: 30px; border: 1px solid #e1e5e9; border-top: none; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #6c757d; border-radius: 0 0 8px 8px; }
        .info-box { background: #e7f3ff; padding: 15px; border-left: 4px solid #007bff; margin: 20px 0; border-radius: 4px; }
        .changes-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .changes-table th, .changes-table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        .changes-table th { background-color: #f8f9fa; font-weight: 600; }
        .user-details { background: #f8f9fa; padding: 15px; border-radius: 6px; margin: 20px 0; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .btn:hover { background-color: #218838; }
        .warning { background-color: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 20px 0; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>👤 User Account Updated</h1>
        <p>Administrative Notification</p>
    </div>
    
    <div class="content">
        <p>Hello Administrator,</p>
        
        <p>This is an automated notification to inform you that a user account has been modified in the system.</p>
        
        <div class="user-details">
            <h3>👤 User Information</h3>
            <p><strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Company:</strong> {{ $user->company->company_name ?? 'N/A' }}</p>
            <p><strong>Current Role:</strong> {{ $user->role->name ?? 'N/A' }}</p>
            <p><strong>Status:</strong> 
                <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; 
                      background-color: {{ $user->status === 'active' ? '#d4edda' : ($user->status === 'inactive' ? '#f8d7da' : '#fff3cd') }};
                      color: {{ $user->status === 'active' ? '#155724' : ($user->status === 'inactive' ? '#721c24' : '#856404') }};">
                    {{ ucfirst($user->status) }}
                </span>
            </p>
        </div>
        
        <div class="info-box">
            <p><strong>📝 Update Details:</strong></p>
            <p><strong>Updated by:</strong> {{ $updatedBy->name }} ({{ $updatedBy->email }})</p>
            <p><strong>Updated on:</strong> {{ now()->format('F j, Y \a\t g:i A T') }}</p>
            <p><strong>IP Address:</strong> {{ request()->ip() }}</p>
        </div>
        
        @if(count($changesSummary) > 0)
            <h3>🔄 Changes Made</h3>
            <table class="changes-table">
                <thead>
                    <tr>
                        <th>Field</th>
                        <th>Previous Value</th>
                        <th>New Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($changesSummary as $change)
                        <tr>
                            <td><strong>{{ $change['field'] }}</strong></td>
                            <td>{{ $change['from'] }}</td>
                            <td><strong>{{ $change['to'] }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        
        @if(isset($changes['role']) || isset($changes['status']) || isset($changes['company']))
            <div class="warning">
                <strong>⚠️ Significant Changes Detected:</strong>
                <p>This update includes changes to critical user properties (role, status, or company assignment). Please review these changes to ensure they align with your organization's policies.</p>
            </div>
        @endif
        
        @if(isset($changes['password']))
            <div class="warning">
                <strong>🔐 Security Notice:</strong>
                <p>The user's password has been {{ $changes['password']['to'] === 'New password generated' ? 'automatically generated' : 'manually updated' }}. The user has been notified via email with appropriate security instructions.</p>
            </div>
        @endif
        
        <div style="text-align: center;">
            <a href="{{ config('app.url') }}/admin/users" class="btn">View User Management</a>
        </div>
        
        <div class="info-box">
            <p><strong>📋 Recommended Actions:</strong></p>
            <ul>
                <li>Review the changes to ensure they are appropriate</li>
                <li>Verify that the person making changes has proper authorization</li>
                <li>Check if any additional access permissions need to be updated</li>
                @if(isset($changes['email']))
                    <li>Monitor for any email delivery issues to the new address</li>
                @endif
                @if(isset($changes['role']))
                    <li>Ensure the new role assignment aligns with the user's responsibilities</li>
                @endif
            </ul>
        </div>
        
        <p>This notification is sent to maintain security and audit compliance. If you have any concerns about these changes, please investigate immediately.</p>
        
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