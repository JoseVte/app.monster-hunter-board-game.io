<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class UserInvitation extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $acceptUrl;

    /**
     * The raw token is passed in rather than read off the invitation, which only
     * ever holds its hash.
     */
    public function __construct(public Invitation $invitation, string $token)
    {
        $this->acceptUrl = route('invitations.show', ['token' => $token]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('You have been invited to :app', ['app' => config('app.name')]),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.user-invitation',
        );
    }
}
