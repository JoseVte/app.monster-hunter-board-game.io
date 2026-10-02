<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * A campaign is played out of the Ancient Forest, the Wildspire Waste, or
     * both, and `IncludesABaseGame` refuses to save one with neither. Every
     * campaign stored before `campaigns.expansions` existed has `null` there,
     * so until somebody ticked a box, neither form would save it, not even to
     * rename it. This gives each of them the Ancient Forest, the box the create
     * form starts out ticked with (`MonsterExpansion::defaultCampaignBox()`).
     *
     * Whatever a campaign already lists is kept, the base game goes in front of
     * it, and a campaign that already names either base game is left alone.
     *
     * The case names are written out here rather than read from the enum on
     * purpose. A migration has to keep meaning what it meant the day it ran;
     * renaming a case later must not change what this one does on a database
     * that has not run it yet.
     *
     * The query builder rather than the model, so `Campaign::booted()` does not
     * recompute anyone's timer on the way through. It would not change it (the
     * Ancient Forest adds no days), but a data fix should touch the one column
     * it is about.
     */
    public function up(): void
    {
        $baseGames = ['ANCIENT_FOREST', 'WILDSPIRE_WASTE'];

        DB::table('campaigns')->orderBy('id')->each(function (object $campaign) use ($baseGames): void {
            $expansions = json_decode($campaign->expansions ?? '[]', true) ?: [];

            if (array_intersect($expansions, $baseGames) !== []) {
                return;
            }

            DB::table('campaigns')->where('id', $campaign->id)->update([
                'expansions' => json_encode(['ANCIENT_FOREST', ...$expansions]),
            ]);
        });
    }

    /**
     * Deliberately empty. Once this has run there is no telling a campaign it
     * gave the Ancient Forest to from one whose owner ticked it, so taking it
     * away again would strip a real choice from some of them. A rolled-back
     * database is left with base games it can still save, which is the state
     * this exists to reach anyway.
     */
    public function down(): void
    {
        //
    }
};
