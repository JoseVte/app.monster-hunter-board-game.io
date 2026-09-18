<?php

use App\Models\Monster;
use App\Models\DowntimeActivity;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// Several create migrations were edited in place after they had already run, so
// databases created before those edits are missing the columns the migration
// files declare today. Every change here is guarded, which makes this a no-op on
// a database built from scratch.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weapon_types', function (Blueprint $table): void {
            if (! Schema::hasColumn('weapon_types', 'image_path')) {
                $table->text('image_path')->nullable();
            }
        });

        Schema::table('weapons', function (Blueprint $table): void {
            if (! Schema::hasColumn('weapons', 'deviation')) {
                $table->string('deviation')->nullable();
            }
        });

        Schema::table('armors', function (Blueprint $table): void {
            if (! Schema::hasColumn('armors', 'branch_id')) {
                $table->foreignIdFor(Monster::class, 'branch_id')->nullable()->constrained('monsters');
            }

            if (! Schema::hasColumn('armors', 'branch')) {
                $table->string('branch')->nullable();
            }

            if (! Schema::hasColumn('armors', 'rarity')) {
                $table->integer('rarity')->default(1);
            }
        });

        Schema::table('days', function (Blueprint $table): void {
            if (! Schema::hasColumn('days', 'downtime_activity_id')) {
                $table->foreignIdFor(DowntimeActivity::class)->nullable()->constrained();
            }

            if (! Schema::hasColumn('days', 'all_hunters_same_activity')) {
                $table->boolean('all_hunters_same_activity')->default(false);
            }
        });
    }
};
