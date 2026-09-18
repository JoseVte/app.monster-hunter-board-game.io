<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// Achievement progress counted the equipment a hunter owned, but an upgrade
// replaces the weapon it was made from, so somebody could craft all evening and
// watch the number stand still. What the achievement is about is the act of
// crafting, so the act is what gets recorded.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crafts', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->morphs('craftable');
            $table->timestamps();

            $table->index(['user_id', 'craftable_type']);
        });

        $this->recordWhatEveryoneAlreadyOwns();
    }

    /**
     * Without this every existing account would drop to whatever it happens to
     * hold today, which for anyone who has upgraded is less than they earned.
     * It still undercounts replaced parents, but it never takes progress away.
     */
    private function recordWhatEveryoneAlreadyOwns(): void
    {
        foreach (['weapon' => 'hunter_weapon', 'armor' => 'hunter_armor'] as $kind => $pivot) {
            $rows = DB::table($pivot)
                ->join('hunters', 'hunters.id', '=', "$pivot.hunter_id")
                ->join('campaign_user', 'campaign_user.hunter_id', '=', 'hunters.id')
                ->select([
                    'campaign_user.user_id',
                    "$pivot.{$kind}_id as craftable_id",
                    "$pivot.created_at",
                ])
                ->get();

            foreach ($rows->chunk(500) as $chunk) {
                DB::table('crafts')->insert($chunk->map(fn ($row): array => [
                    'user_id' => $row->user_id,
                    'craftable_type' => $kind === 'weapon' ? App\Models\Weapon::class : App\Models\Armor::class,
                    'craftable_id' => $row->craftable_id,
                    'created_at' => $row->created_at ?? now(),
                    'updated_at' => now(),
                ])->all());
            }
        }
    }
};
