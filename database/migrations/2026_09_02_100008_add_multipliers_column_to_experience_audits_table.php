<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(config('level-up.tables.experience_audits'), function (Blueprint $table): void {
            $table->json('multipliers')->nullable()->after('reason');
        });
    }

    public function down(): void
    {
        Schema::table(config('level-up.tables.experience_audits'), function (Blueprint $table): void {
            $table->dropColumn('multipliers');
        });
    }
};
