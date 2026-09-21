<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Actions\Invitations\CreateInvitation;

/**
 * Issues a platform invitation from the command line and prints its link.
 *
 * This is how the first account on a fresh database gets in. Registration is
 * closed by default, and the admin account the seeders used to create came with
 * a password written in the environment file, which is a worse way to hand
 * somebody an account than letting them choose their own.
 *
 * Nothing is emailed. The link is printed once, because the table stores only a
 * hash of the token and it cannot be recovered afterwards.
 */
class CreateInvitationCommand extends Command
{
    protected $signature = 'invitation:create
                            {email? : Lock the invitation to this address. Leave it out and any address may use it.}
                            {--from= : The email of the user issuing it. Defaults to the console itself.}';

    protected $description = 'Issue a platform invitation and print its link.';

    public function handle(CreateInvitation $createInvitation): int
    {
        $inviter = null;

        if ($from = $this->option('from')) {
            $inviter = User::where('email', $from)->first();

            if (! $inviter) {
                $this->components->error("No user with the address {$from}.");

                return self::FAILURE;
            }
        }

        ['invitation' => $invitation, 'token' => $token] = $createInvitation(
            $inviter,
            $this->argument('email'),
        );

        $this->components->twoColumnDetail('From', $inviter?->email ?? 'the console');
        $this->components->twoColumnDetail('For', $invitation->email ?? 'any address');
        $this->components->twoColumnDetail('Expires', $invitation->expires_at->toDayDateTimeString());

        $this->newLine();
        $this->line(route('invitations.show', $token));
        $this->newLine();

        $this->components->warn('Shown once. The table keeps only a hash of the token, so this link cannot be printed again.');

        return self::SUCCESS;
    }
}
