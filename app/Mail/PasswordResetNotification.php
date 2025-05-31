<?php

// App/Mail/PasswordResetNotification.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class PasswordResetNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $newPassword;
    public $updatedBy;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $newPassword, User $updatedBy)
    {
        $this->user = $user;
        $this->newPassword = $newPassword;
        $this->updatedBy = $updatedBy;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Password Has Been Updated',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.password-reset',
            with: [
                'user' => $this->user,
                'newPassword' => $this->newPassword,
                'updatedBy' => $this->updatedBy,
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