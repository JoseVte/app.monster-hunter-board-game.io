<?php

use App\Models\Item;
use App\Models\User;
use App\Models\Armor;
use App\Models\Hunter;
use App\Models\Weapon;
use App\Models\Campaign;
use Spatie\Permission\Models\Role;
use App\Events\UserEquipmentCrafted;
use Inertia\Testing\AssertableInertia;

beforeEach(function (): void {
    $this->owner = User::factory()->withPersonalTeam()->create();
    $this->campaign = Campaign::factory()->create(['team_id' => $this->owner->currentTeam->id]);
    $this->ownersHunter = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);
    $this->playersHunter = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);
    $this->campaign->users()->updateExistingPivot($this->owner->id, ['hunter_id' => $this->ownersHunter->id]);

    $this->player = User::factory()->create();
    $this->campaign->users()->attach($this->player, [
        'role_id' => Role::findByName('member-campaign', 'sanctum')->id,
        'hunter_id' => $this->playersHunter->id,
    ]);

    $this->admin = User::factory()->create();
    $this->campaign->users()->attach($this->admin, [
        'role_id' => Role::findByName('admin-campaign', 'sanctum')->id,
    ]);
});

test('any member of the campaign can look at every hunter in it', function (User $viewer): void {
    $this->actingAs($viewer)
        ->get(route('campaigns.hunters.show', [$this->campaign, $this->ownersHunter]))
        ->assertOk();

    $this->actingAs($viewer)
        ->get(route('campaigns.hunters.weapon-type.index', [$this->campaign, $this->ownersHunter, Weapon::factory()->create()->type]))
        ->assertOk();
})->with([
    'the player of another hunter' => fn () => $this->player,
    'an administrator' => fn () => $this->admin,
]);

test('the hunter page only offers editing to whoever may edit the hunter', function (): void {
    $this->actingAs($this->player)
        ->get(route('campaigns.hunters.show', [$this->campaign, $this->ownersHunter]))
        ->assertInertia(fn (AssertableInertia $page) => $page->where('canEdit', false));

    $this->actingAs($this->player)
        ->get(route('campaigns.hunters.show', [$this->campaign, $this->playersHunter]))
        ->assertInertia(fn (AssertableInertia $page) => $page->where('canEdit', true));

    $this->actingAs($this->owner)
        ->get(route('campaigns.hunters.show', [$this->campaign, $this->playersHunter]))
        ->assertInertia(fn (AssertableInertia $page) => $page->where('canEdit', true));
});

test('a player can rename and delete their own hunter', function (): void {
    $this->actingAs($this->player);

    $this->get(route('campaigns.hunters.edit', [$this->campaign, $this->playersHunter]))->assertOk();
    $this->put(route('campaigns.hunters.update', [$this->campaign, $this->playersHunter]), ['name' => 'Renamed'])
        ->assertStatus(303);

    expect($this->playersHunter->fresh()->name)->toBe('Renamed');

    $this->delete(route('campaigns.hunters.destroy', [$this->campaign, $this->playersHunter]))
        ->assertRedirectToRoute('campaigns.show', $this->campaign);

    expect($this->playersHunter->fresh())->toBeNull();
});

test('the owner of the campaign can rename and delete the hunter of another player', function (): void {
    $this->actingAs($this->owner);

    $this->put(route('campaigns.hunters.update', [$this->campaign, $this->playersHunter]), ['name' => 'Renamed'])
        ->assertStatus(303);

    expect($this->playersHunter->fresh()->name)->toBe('Renamed');

    $this->delete(route('campaigns.hunters.destroy', [$this->campaign, $this->playersHunter]))
        ->assertRedirectToRoute('campaigns.show', $this->campaign);

    expect($this->playersHunter->fresh())->toBeNull();
});

test('nobody but the owner and the player can rename a hunter', function (User $member): void {
    $this->actingAs($member);

    $this->get(route('campaigns.hunters.edit', [$this->campaign, $this->ownersHunter]))->assertForbidden();
    $this->put(route('campaigns.hunters.update', [$this->campaign, $this->ownersHunter]), ['name' => 'Renamed'])
        ->assertForbidden();

    expect($this->ownersHunter->fresh()->name)->not->toBe('Renamed');
})->with([
    'the player of another hunter' => fn () => $this->player,
    'an administrator' => fn () => $this->admin,
]);

test('a player cannot delete the hunter of another player', function (): void {
    $this->actingAs($this->player)
        ->delete(route('campaigns.hunters.destroy', [$this->campaign, $this->ownersHunter]))
        ->assertForbidden();

    expect($this->ownersHunter->fresh())->not->toBeNull();
});

test('an administrator can delete the hunter of another player', function (): void {
    $this->actingAs($this->admin)
        ->delete(route('campaigns.hunters.destroy', [$this->campaign, $this->playersHunter]))
        ->assertRedirectToRoute('campaigns.show', $this->campaign);

    expect($this->playersHunter->fresh())->toBeNull();
});

test('nobody but the owner and the player can craft, equip or count parts for a hunter', function (User $member): void {
    Event::fake(UserEquipmentCrafted::class);
    $item = Item::factory()->create();
    $weapon = Weapon::factory()->create(['is_default' => false]);
    $owned = Weapon::factory()->create(['is_default' => false]);
    $armor = Armor::factory()->create(['is_default' => false]);
    $ownedArmor = Armor::factory()->create(['is_default' => false]);
    $this->ownersHunter->weapons()->attach($owned);
    $this->ownersHunter->armors()->attach($ownedArmor);

    $this->actingAs($member);
    $this->post(route('campaigns.hunters.weapons.craft', [$this->campaign, $this->ownersHunter, $weapon->type, $weapon]))->assertForbidden();
    $this->put(route('campaigns.hunters.weapons.equip', [$this->campaign, $this->ownersHunter, $owned->type, $owned]), ['equip' => true])->assertForbidden();
    $this->post(route('campaigns.hunters.armors.craft', [$this->campaign, $this->ownersHunter, $armor]))->assertForbidden();
    $this->put(route('campaigns.hunters.armors.equip', [$this->campaign, $this->ownersHunter, $ownedArmor]), ['equip' => true])->assertForbidden();
    $this->put(route('campaigns.hunters.items.update-count', [$this->campaign, $this->ownersHunter, $item]), ['count_item' => 9])
        ->assertForbidden();

    expect($this->ownersHunter->weapons()->count())->toBe(1)
        ->and($this->ownersHunter->equippedWeapons()->count())->toBe(0)
        ->and($this->ownersHunter->armors()->count())->toBe(1)
        ->and($this->ownersHunter->equippedArmors()->count())->toBe(0)
        ->and($this->ownersHunter->items()->count())->toBe(0);
    Event::assertNotDispatched(UserEquipmentCrafted::class);
})->with([
    'the player of another hunter' => fn () => $this->player,
    'an administrator' => fn () => $this->admin,
]);

test('the owner of the campaign can craft and count parts for the hunter of another player', function (): void {
    Event::fake(UserEquipmentCrafted::class);
    $item = Item::factory()->create();
    $weapon = Weapon::factory()->create(['is_default' => false]);

    $this->actingAs($this->owner);
    $this->post(route('campaigns.hunters.weapons.craft', [$this->campaign, $this->playersHunter, $weapon->type, $weapon]))
        ->assertStatus(303);
    $this->put(route('campaigns.hunters.items.update-count', [$this->campaign, $this->playersHunter, $item]), ['count_item' => 9])
        ->assertStatus(303);

    expect($this->playersHunter->weapons()->count())->toBe(1)
        ->and($this->playersHunter->items()->find($item->id)->pivot->number)->toBe(9);
});

test('a hunter cannot be edited through a campaign it does not belong to', function (): void {
    $foreignHunter = Hunter::factory()->create();
    $weapon = Weapon::factory()->create(['is_default' => false]);

    $this->actingAs($this->owner);
    $this->get(route('campaigns.hunters.weapon-type.index', [$this->campaign, $foreignHunter, $weapon->type]))->assertForbidden();
    $this->post(route('campaigns.hunters.weapons.craft', [$this->campaign, $foreignHunter, $weapon->type, $weapon]))->assertForbidden();
    $this->put(route('campaigns.hunters.weapon-type.hunt', [$this->campaign, $foreignHunter, $weapon->type]))->assertForbidden();

    expect($foreignHunter->weapons()->count())->toBe(0)
        ->and($foreignHunter->fresh()->weapon_type_id)->not->toBe($weapon->type_id);
});

test('any member of the campaign can add a hunter to it', function (): void {
    $this->actingAs($this->admin);

    $this->get(route('campaigns.hunters.create', $this->campaign))->assertOk();
    $this->post(route('campaigns.hunters.store', $this->campaign), ['name' => 'Newcomer'])->assertRedirect();

    expect($this->campaign->hunters()->where('name', 'Newcomer')->exists())->toBeTrue();
});
