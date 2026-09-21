<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

/**
 * The message `mail:test` sends.
 *
 * It is a markdown mailable rather than a raw string on purpose: that way the
 * check exercises the same view rendering and the same layout as the mail the
 * app actually sends, instead of only proving that the transport opens a socket.
 *
 * The property is not called `$mailer`, which would read better, because
 * Mailable already declares one and a typed redeclaration is a fatal error.
 */
class TestMessage extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public string $sentThrough) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Mail test from :app', ['app' => config('app.name')]),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.mail-test',
        );
    }
}
