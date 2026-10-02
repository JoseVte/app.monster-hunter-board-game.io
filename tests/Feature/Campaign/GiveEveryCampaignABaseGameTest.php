<?php

use App\Models\Team;
use Illuminate\Support\Facades\DB;

/*
 * The data migration that lets campaigns stored before `campaigns.expansions`
 * existed be saved again. Rows are written with the query builder, not the
 * model or the factory, because they have to look the way old rows do (no
 * expansions at all), which the factory no longer produces.
 */
function campaignRow(?array $expansions): int
{
    return DB::table('campaigns')->insertGetId([
        'team_id' => Team::factory()->create()->id,
        'name' => 'Old campaign',
        'max_days' => 33,
        'expansions' => $expansions === null ? null : json_encode($expansions),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

function runBaseGameMigration(): void
{
    (require database_path('migrations/2026_10_02_100000_give_every_campaign_a_base_game.php'))->up();
}

function expansionsOf(int $id): ?array
{
    return json_decode(DB::table('campaigns')->where('id', $id)->value('expansions'), true);
}

test('a campaign stored with no expansions gets the Ancient Forest', function (): void {
    $id = campaignRow(null);

    runBaseGameMigration();

    expect(expansionsOf($id))->toBe(['ANCIENT_FOREST']);
});

test('a campaign with only add-ons keeps them, behind the Ancient Forest', function (): void {
    $id = campaignRow(['PICKING_BONES', 'KIRIN_EXPANSION']);

    runBaseGameMigration();

    expect(expansionsOf($id))->toBe(['ANCIENT_FOREST', 'PICKING_BONES', 'KIRIN_EXPANSION']);
});

test('a campaign that already names a base game is left exactly as it was', function (): void {
    $wildspire = campaignRow(['WILDSPIRE_WASTE', 'PICKING_BONES']);
    $both = campaignRow(['ANCIENT_FOREST', 'WILDSPIRE_WASTE']);

    runBaseGameMigration();

    expect(expansionsOf($wildspire))->toBe(['WILDSPIRE_WASTE', 'PICKING_BONES'])
        ->and(expansionsOf($both))->toBe(['ANCIENT_FOREST', 'WILDSPIRE_WASTE']);
});

test('the timer is not touched', function (): void {
    $id = campaignRow(null);

    runBaseGameMigration();

    expect(DB::table('campaigns')->where('id', $id)->value('max_days'))->toBe(33);
});

test('running it twice changes nothing the second time', function (): void {
    $id = campaignRow(['PICKING_BONES']);

    runBaseGameMigration();
    runBaseGameMigration();

    expect(expansionsOf($id))->toBe(['ANCIENT_FOREST', 'PICKING_BONES']);
});

test('a campaign it fixed can be saved from the edit form again', function (): void {
    $this->actingAs($user = App\Models\User::factory()->withPersonalTeam()->create());
    $id = campaignRow(null);
    DB::table('campaigns')->where('id', $id)->update(['team_id' => $user->currentTeam->id]);
    App\Models\Campaign::find($id)->users()->attach($user, [
        'role_id' => Spatie\Permission\Models\Role::findByName('admin-campaign', 'sanctum')->id,
    ]);

    runBaseGameMigration();

    // What `UpdateCampaignForm` posts: every field, the expansions included.
    $this->put(route('campaigns.update', $id), [
        'name' => 'Renamed at last',
        'max_days' => 33,
        'expansions' => expansionsOf($id),
    ])->assertSessionHasNoErrors();

    expect(DB::table('campaigns')->where('id', $id)->value('name'))->toBe('Renamed at last');
});
