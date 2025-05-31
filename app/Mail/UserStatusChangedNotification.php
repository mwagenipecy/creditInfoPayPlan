<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserStatusChangedNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $changedBy;
    public $action;
    public $reason;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, User $changedBy, string $action, string $reason = null)
    {
        $this->user = $user;
        $this->changedBy = $changedBy;
        $this->action = $action; // 'blocked' or 'unblocked'
        $this->reason = $reason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $action = ucfirst($this->action);
        return new Envelope(
            subject: "User {$action} - Admin Notification",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user-status-changed-admin',
            with: [
                'user' => $this->user,
                'changedBy' => $this->changedBy,
                'action' => $this->action,
                'reason' => $this->reason,
                'adminUrl' => config('app.url') . '/admin/users',
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}