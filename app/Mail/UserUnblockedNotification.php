<?php

// App/Mail/UserUnblockedNotification.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserUnblockedNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $unblockedBy;
    public $reason;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, User $unblockedBy, string $reason = null)
    {
        $this->user = $user;
        $this->unblockedBy = $unblockedBy;
        $this->reason = $reason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Account Access Restored - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user-unblocked-notification',
            with: [
                'user' => $this->user,
                'unblockedBy' => $this->unblockedBy,
                'reason' => $this->reason,
                'loginUrl' => config('app.url') . '/login',
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