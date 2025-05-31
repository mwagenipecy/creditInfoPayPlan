<?php

// App/Mail/EmailVerificationConfirmation.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class EmailVerificationConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $verifiedBy;
    public $reason;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, User $verifiedBy, string $reason = null)
    {
        $this->user = $user;
        $this->verifiedBy = $verifiedBy;
        $this->reason = $reason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Address Verified - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email-verification-confirmation',
            with: [
                'user' => $this->user,
                'verifiedBy' => $this->verifiedBy,
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