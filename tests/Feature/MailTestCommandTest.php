<?php

use App\Mail\TestMessage;
use Illuminate\Support\Facades\Mail;

// What these cover is the command, not the mail transport. A test cannot say
// whether Mailjet accepts the credentials or whether the server can reach it;
// only running `mail:test` on that server answers that, which is why the
// command exists.

test('it sends to the recipient given', function (): void {
    Mail::fake();

    $this->artisan('mail:test', ['recipient' => 'someone@example.com'])
        ->assertSuccessful();

    Mail::assertSent(TestMessage::class, fn ($mail) => $mail->hasTo('someone@example.com'));
});

test('it falls back to the from address', function (): void {
    Mail::fake();
    config(['mail.from.address' => 'noreply@example.com']);

    $this->artisan('mail:test')->assertSuccessful();

    Mail::assertSent(TestMessage::class, fn ($mail) => $mail->hasTo('noreply@example.com'));
});

test('it refuses when there is nobody to send to', function (): void {
    Mail::fake();
    config(['mail.from.address' => null]);

    $this->artisan('mail:test')->assertFailed();

    Mail::assertNothingSent();
});

// The reason the command exists is to show why sending failed. Swallowing the
// transport error would leave the same "it does not work" it was written to
// answer, so the message has to reach the operator and the exit code has to say
// so, since a deploy or a shell script reads that and not the output.
test('a transport failure is reported and fails the command', function (): void {
    Mail::shouldReceive('to->send')->once()->andThrow(new RuntimeException('535 Authentication failed'));

    $this->artisan('mail:test', ['recipient' => 'someone@example.com'])
        ->expectsOutputToContain('535 Authentication failed')
        ->assertFailed();
});
