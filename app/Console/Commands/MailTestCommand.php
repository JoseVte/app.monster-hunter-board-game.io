<?php

namespace App\Console\Commands;

use Throwable;
use App\Mail\TestMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

/**
 * Sends one real message through whatever mailer is configured.
 *
 * A test in the Pest suite cannot answer the question this exists for. It runs
 * against the array mailer, so it proves the code works and says nothing at all
 * about whether Mailjet accepts the credentials or whether the server can reach
 * it. Only sending does that, and only from the machine that will be sending.
 */
class MailTestCommand extends Command
{
    protected $signature = 'mail:test {recipient? : Where to send it. Defaults to the configured from address.}';

    protected $description = 'Send a real message through the configured mailer to check it works.';

    public function handle(): int
    {
        $mailer = config('mail.default');
        $from = config('mail.from.address');
        $recipient = $this->argument('recipient') ?? $from;

        if (blank($recipient)) {
            $this->components->error('No recipient given and MAIL_FROM_ADDRESS is not set.');

            return self::FAILURE;
        }

        // Printed before sending rather than after, so a run that hangs on a
        // blocked port still tells you what it was trying to reach.
        $this->components->twoColumnDetail('Mailer', $mailer);
        $this->components->twoColumnDetail('From', $from ?: '<unset>');
        $this->components->twoColumnDetail('To', $recipient);

        try {
            Mail::to($recipient)->send(new TestMessage($mailer));
        } catch (Throwable $e) {
            // The whole point. A transport failure carries the reason, the
            // authentication error or the refused connection, and swallowing it
            // would leave the same "it does not work" this was written to answer.
            $this->components->error($e->getMessage());

            return self::FAILURE;
        }

        $this->components->info('Handed to the mailer without error. Check the inbox: delivery is its own question.');

        return self::SUCCESS;
    }
}
