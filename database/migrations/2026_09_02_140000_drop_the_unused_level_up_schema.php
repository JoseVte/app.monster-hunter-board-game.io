<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// The experience and achievement code is now local, and it covers levels,
// points and achievement progress only. Streaks, tiers, multipliers, challenges
// and the points ledger came with cjmellor/level-up, had to be migrated for it
// to boot and were never read by anything in this application.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('experiences', function (Blueprint $table): void {
            if (Schema::hasColumn('experiences', 'tier_id')) {
                $table->dropConstrainedForeignId('tier_id');
            }
        });

        Schema::table('achievements', function (Blueprint $table): void {
            if (Schema::hasColumn('achievements', 'tier_id')) {
                $table->dropConstrainedForeignId('tier_id');
            }
        });

        Schema::table('users', function (Blueprint $table): void {
            if (Schema::hasColumn('users', 'level_id')) {
                $table->dropConstrainedForeignId('level_id');
            }
        });

        Schema::dropIfExists('challenge_user');
        Schema::dropIfExists('challenges');
        Schema::dropIfExists('multiplier_scopes');
        Schema::dropIfExists('multipliers');
        Schema::dropIfExists('streak_histories');
        Schema::dropIfExists('streaks');
        Schema::dropIfExists('streak_activities');
        Schema::dropIfExists('experience_audits');
        Schema::dropIfExists('tiers');
    }
};
