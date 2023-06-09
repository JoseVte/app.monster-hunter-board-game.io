<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use App\Models\CampaignInvitation as CampaignInvitationModel;

class CampaignInvitation extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $acceptUrl;

    public function __construct(public CampaignInvitationModel $invitation)
    {
        $this->acceptUrl = URL::signedRoute('campaign-invitations.accept', [
            'invitation' => $this->invitation,
        ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Campaign Invitation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.campaign-invitation',
        );
    }
}
