<?php

use App\Models\Item;
use App\Models\Armor;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('count_item_armor', function (Blueprint $table): void {
            $table->id();

            $table->foreignIdFor(Armor::class)->constrained();
            $table->foreignIdFor(Item::class)->constrained();

            $table->integer('number');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('count_item_armor');
    }
};
