<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Choosing up to three activities on a downtime day turned out to be the
     * rule rather than an alternative to it, which is what the second entry
     * under `downtime` in `resources/lang/en/campaign-rules.php` says, so the
     * opt-in that `..._let_a_campaign_play_by_the_alternative_rules` added a
     * week ago is gone and every campaign plays that way.
     *
     * Written as its own migration rather than by editing that one, which has
     * already run on a real database.
     */
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table): void {
            $table->dropColumn('alternative_rules');
        });
    }

    /**
     * The column comes back at its default, not at what each campaign held.
     *
     * There is nowhere to read the old values back from, and nothing consults
     * the column any more, so a rollback restores the shape and not the data.
     * That is lossless in practice: the flag was never deployed.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table): void {
            $table->boolean('alternative_rules')->default(false)->after('health_potions');
        });
    }
};
