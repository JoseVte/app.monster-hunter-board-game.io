<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('streaks', function (Blueprint $table): void {
            $table->after('activity_at', function (Blueprint $table): void {
                $table->timestamp('frozen_until')->nullable();
            });
        });
    }

    public function down(): void
    {
        Schema::table('streaks', function (Blueprint $table): void {
            $table->dropColumn('frozen_until');
        });
    }
};
