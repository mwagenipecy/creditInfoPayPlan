<?php

// App/Mail/UserCreatedNotification.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserCreatedNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $createdBy;
    public $isAdminNotification;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $password = null, User $createdBy, bool $isAdminNotification = false)
    {
        $this->user = $user;
        $this->password = $password;
        $this->createdBy = $createdBy;
        $this->isAdminNotification = $isAdminNotification;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if ($this->isAdminNotification) {
            return new Envelope(
                subject: 'New User Created - Admin Notification',
            );
        }

        return new Envelope(
            subject: 'Your Account Credentials - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view = $this->isAdminNotification ? 'emails.user-created-admin' : 'emails.user-created-credentials';

        return new Content(
            view: $view,
            with: [
                'user' => $this->user,
                'password' => $this->password,
                'createdBy' => $this->createdBy,
                'loginUrl' => config('app.url') . '/login',
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
