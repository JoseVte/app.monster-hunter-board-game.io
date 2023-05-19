<?php

use App\Models\Armor;
use App\Models\Hunter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hunter_armor', function (Blueprint $table): void {
            $table->id();

            $table->foreignIdFor(Armor::class)->constrained();
            $table->foreignIdFor(Hunter::class)->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hunter_armor');
    }
};
