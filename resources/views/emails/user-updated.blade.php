{{-- resources/views/emails/user-updated.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Updated</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #ffffff; padding: 30px; border: 1px solid #e1e5e9; border-top: none; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #6c757d; border-radius: 0 0 8px 8px; }
        .changes-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .changes-table th, .changes-table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        .changes-table th { background-color: #f8f9fa; font-weight: 600; }
        .highlight { background-color: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 20px 0; border-radius: 4px; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Account Information Updated</h1>
        <p>Your account details have been modified</p>
    </div>
    
    <div class="content">
        <p>Hello <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>,</p>
        
        <p>This email is to inform you that your account information has been updated by <strong>{{ $updatedBy->name }}</strong> on {{ now()->format('F j, Y \a\t g:i A') }}.</p>
        
        @if(count($changesSummary) > 0)
            <div class="highlight">
                <strong>Changes Made:</strong>
            </div>
            
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
        
        @if(isset($changes['email']))
            <div class="highlight">
                <strong>Important:</strong> Your email address has been changed. You may need to verify your new email address before accessing certain features.
            </div>
        @endif
        
        @if(isset($changes['password']))
            <div class="highlight">
                <strong>Security Notice:</strong> Your password has been updated. If you did not request this change, please contact your administrator immediately.
            </div>
        @endif
        
        <p>If you have any questions about these changes or if you did not expect this update, please contact your system administrator.</p>
        
        <a href="{{ config('app.url') }}/login" class="btn">Access Your Account</a>
        
        <p>Best regards,<br>
        <strong>{{ config('app.name') }} Team</strong></p>
    </div>
    
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>