<?php

// App/Mail/UserUpdatedNotification.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserUpdatedNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $changes;
    public $updatedBy;
    public $isAdminNotification;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, array $changes, User $updatedBy, bool $isAdminNotification = false)
    {
        $this->user = $user;
        $this->changes = $changes;
        $this->updatedBy = $updatedBy;
        $this->isAdminNotification = $isAdminNotification;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->isAdminNotification 
            ? "User Account Updated - {$this->user->name}"
            : "Your Account Information Has Been Updated";

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view = $this->isAdminNotification 
            ? 'emails.user-updated-admin'
            : 'emails.user-updated';

        return new Content(
            view: $view,
            with: [
                'user' => $this->user,
                'changes' => $this->changes,
                'updatedBy' => $this->updatedBy,
                'changesSummary' => $this->formatChanges(),
            ]
        );
    }

    /**
     * Format changes for display
     */
    private function formatChanges(): array
    {
        $formatted = [];
        
        foreach ($this->changes as $field => $change) {
            $formatted[] = [
                'field' => $this->formatFieldName($field),
                'from' => $change['from'],
                'to' => $change['to']
            ];
        }
        
        return $formatted;
    }

    /**
     * Format field names for display
     */
    private function formatFieldName(string $field): string
    {
        return match($field) {
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email Address',
            'company' => 'Company',
            'role' => 'Role',
            'status' => 'Account Status',
            'password' => 'Password',
            default => ucfirst(str_replace('_', ' ', $field))
        };
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}