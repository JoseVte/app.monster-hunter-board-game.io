<?php

use App\Models\SongList;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Which list a horn plays from is printed on its own card, so it belongs to
     * the weapon rather than to its type: the twenty horns share ten lists.
     */
    public function up(): void
    {
        Schema::table('weapons', function (Blueprint $table): void {
            $table->foreignIdFor(SongList::class)->nullable()->after('deviation')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('weapons', function (Blueprint $table): void {
            $table->dropConstrainedForeignIdFor(SongList::class);
        });
    }
};
