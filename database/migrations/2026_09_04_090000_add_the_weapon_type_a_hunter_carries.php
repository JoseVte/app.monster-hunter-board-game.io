<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * A hunter keeps a favourite weapon of every type, which is what
     * hunter_weapon.equipped records, but carries only one of those types into a
     * hunt. The two are separate choices, so this is its own column rather than
     * another flag on the pivot.
     */
    public function up(): void
    {
        Schema::table('hunters', function (Blueprint $table): void {
            $table->foreignId('weapon_type_id')
                ->nullable()
                ->after('campaign_id')
                ->constrained()
                ->nullOnDelete();
        });

        // Everyone starts on the great sword, so nobody who already exists is
        // left carrying nothing.
        $greatSword = DB::table('weapon_types')
            ->whereJsonContains('name->en', 'Great Sword')
            ->value('id');

        if ($greatSword) {
            DB::table('hunters')->whereNull('weapon_type_id')->update(['weapon_type_id' => $greatSword]);
        }
    }

    public function down(): void
    {
        Schema::table('hunters', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('weapon_type_id');
        });
    }
};
