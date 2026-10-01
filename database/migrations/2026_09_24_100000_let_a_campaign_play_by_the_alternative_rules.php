<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Under the alternative rules a hunter picks up to three different
     * activities on a downtime day instead of one. It is a property of the
     * campaign rather than of a day, because it changes how every downtime day
     * in that campaign is read, and it defaults to false so every campaign that
     * already exists keeps playing exactly as it did.
     */
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table): void {
            $table->boolean('alternative_rules')->default(false)->after('health_potions');
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table): void {
            $table->dropColumn('alternative_rules');
        });
    }
};
