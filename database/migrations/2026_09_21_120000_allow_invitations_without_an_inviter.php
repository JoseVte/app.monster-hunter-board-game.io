<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * An invitation issued from the console has no person behind it.
 *
 * Until now `inviter_id` was required, which made the first account on a fresh
 * database impossible to create through the invitation flow: an invitation
 * needed a user, and there was no user to need. `invitation:create` fills that
 * gap, and a null inviter is the honest way to record where it came from rather
 * than inventing a system account that would show up in every user listing
 * forever.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table): void {
            $table->foreignId('inviter_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Console-issued invitations have no inviter to restore, so they are
        // dropped rather than guessed at. They are single use links; reissuing
        // one costs a command.
        DB::table('invitations')->whereNull('inviter_id')->delete();

        Schema::table('invitations', function (Blueprint $table): void {
            $table->foreignId('inviter_id')->nullable(false)->change();
        });
    }
};
