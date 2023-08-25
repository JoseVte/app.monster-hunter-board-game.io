<?php

use App\Models\Hunter;
use App\Models\Weapon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hunter_weapon', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Hunter::class)->constrained();
            $table->foreignIdFor(Weapon::class)->constrained();

            $table->boolean('equipped')->default(false);

            $table->timestamps();

            $table->index(['hunter_id', 'equipped']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hunter_weapon');
    }
};
