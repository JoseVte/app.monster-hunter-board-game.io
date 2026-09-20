<?php

use App\Models\User;
use App\Models\Armor;
use App\Models\Hunter;
use App\Models\Palico;
use App\Models\Weapon;
use App\Models\Campaign;
use Illuminate\Support\Facades\DB;

test('campaigns can be deleted', function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    $campaign = Campaign::factory()->create(['team_id' => $user->currentTeam->id]);

    $response = $this->delete(route('campaigns.destroy', $campaign));
    $response->assertRedirectToRoute('dashboard');

    expect(Campaign::count())->toEqual(0);
});

// A hunter's weapons, armours, items, downtime days and palico all hang off it
// through foreign keys declared with `constrained()` and no `onDelete`, which
// is RESTRICT. Deleting a campaign whose hunters had ever been equipped used to
// fail on the first of them. The test above never saw it because a campaign
// created straight from the factory has no hunters at all.
test('a campaign goes even when its hunters are equipped', function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());
    $campaign = Campaign::factory()->create(['team_id' => $user->currentTeam->id]);

    $hunter = Hunter::factory()->create(['campaign_id' => $campaign->id]);
    $hunter->weapons()->attach(Weapon::factory()->create());
    $hunter->armors()->attach(Armor::factory()->create());
    Palico::factory()->create(['hunter_id' => $hunter->id, 'name' => 'Meowscular']);

    $this->delete(route('campaigns.destroy', $campaign))
        ->assertRedirectToRoute('dashboard');

    expect(Campaign::count())->toBe(0)
        ->and(Hunter::count())->toBe(0)
        ->and(Palico::count())->toBe(0)
        ->and(DB::table('hunter_weapon')->count())->toBe(0)
        ->and(DB::table('hunter_armor')->count())->toBe(0);
});
