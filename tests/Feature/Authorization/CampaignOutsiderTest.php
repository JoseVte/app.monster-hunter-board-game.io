<?php

use App\Models\Item;
use App\Models\User;
use App\Enum\DayType;
use App\Models\Armor;
use App\Models\Hunter;
use App\Models\Weapon;
use App\Models\Monster;
use App\Models\Campaign;
use App\Enum\MonsterDifficulty;
use App\Events\UserMonsterHunted;
use Spatie\Permission\Models\Role;
use App\Events\UserEquipmentCrafted;

// Somebody signed in who has nothing to do with the campaign: their own team,
// no membership. Every route under /campaigns/{campaign} should turn them away
// before it reads or writes anything of a campaign they cannot see.

beforeEach(function (): void {
    $this->owner = User::factory()->withPersonalTeam()->create();
    $this->campaign = Campaign::factory()->create(['team_id' => $this->owner->currentTeam->id]);
    $this->hunter = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);
    $this->campaign->users()->updateExistingPivot($this->owner->id, ['hunter_id' => $this->hunter->id]);

    $this->outsider = User::factory()->withPersonalTeam()->create();
});

test('an outsider cannot open, edit or delete a campaign', function (): void {
    $this->actingAs($this->outsider);

    $this->get(route('campaigns.show', $this->campaign))->assertForbidden();
    $this->get(route('campaigns.edit', $this->campaign))->assertForbidden();
    $this->put(route('campaigns.update', $this->campaign), ['name' => 'Hijacked'])->assertForbidden();
    $this->delete(route('campaigns.destroy', $this->campaign))->assertForbidden();

    expect($this->campaign->fresh())
        ->not->toBeNull()
        ->name->not->toBe('Hijacked');
});

test('an outsider cannot see, change or delete the hunters of a campaign', function (): void {
    $this->actingAs($this->outsider);

    $this->get(route('campaigns.hunters.show', [$this->campaign, $this->hunter]))->assertForbidden();
    $this->get(route('campaigns.hunters.edit', [$this->campaign, $this->hunter]))->assertForbidden();
    $this->put(route('campaigns.hunters.update', [$this->campaign, $this->hunter]), ['name' => 'Renamed'])->assertForbidden();
    $this->delete(route('campaigns.hunters.destroy', [$this->campaign, $this->hunter]))->assertForbidden();

    expect($this->campaign->hunters()->count())->toBe(1)
        ->and($this->hunter->fresh()->name)->not->toBe('Renamed');
});

test('an outsider cannot log parts or change the weapon of a hunter', function (): void {
    $this->actingAs($this->outsider);
    $item = Item::factory()->create();
    $weapon = Weapon::factory()->create();

    $this->put(route('campaigns.hunters.items.store-many', [$this->campaign, $this->hunter]), [
        'items' => [['item_id' => $item->id, 'number' => 9]],
    ])->assertForbidden();

    $this->put(route('campaigns.hunters.weapon-type.hunt', [$this->campaign, $this->hunter, $weapon->type]))
        ->assertForbidden();

    expect($this->hunter->items()->count())->toBe(0);
});

test('an outsider cannot add, change or remove campaign members', function (): void {
    $this->actingAs($this->outsider);
    $member = User::factory()->create();

    $this->post(route('campaign-members.store', $this->campaign), [
        'email' => $member->email,
        'role' => 'member-campaign',
    ])->assertForbidden();

    $this->put(route('campaign-members.update', [$this->campaign, $this->owner]), [
        'role' => 'member-campaign',
    ])->assertForbidden();

    $this->delete(route('campaign-members.destroy', [$this->campaign, $this->owner]))->assertForbidden();

    expect($this->campaign->users()->pluck('users.id')->all())->toBe([$this->owner->id])
        ->and($this->owner->hasCampaignRole($this->campaign->fresh(), 'admin-campaign'))->toBeTrue();
});

test('a member cannot spend or log parts for somebody else\'s hunter', function (): void {
    $member = User::factory()->create();
    $this->campaign->users()->attach($member, [
        'role_id' => Role::findByName('member-campaign', 'sanctum')->id,
    ]);
    $item = Item::factory()->create();

    $this->actingAs($member)
        ->put(route('campaigns.hunters.items.store-many', [$this->campaign, $this->hunter]), [
            'items' => [['item_id' => $item->id, 'number' => 2]],
        ])
        ->assertForbidden();

    $this->actingAs($member)
        ->put(route('campaigns.hunters.weapon-type.hunt', [$this->campaign, $this->hunter, Weapon::factory()->create()->type]))
        ->assertForbidden();

    expect($this->hunter->items()->count())->toBe(0);
});

test('a member can log parts for their own hunter', function (): void {
    $member = User::factory()->create();
    $ownHunter = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);
    $this->campaign->users()->attach($member, [
        'role_id' => Role::findByName('member-campaign', 'sanctum')->id,
        'hunter_id' => $ownHunter->id,
    ]);
    $item = Item::factory()->create();

    $this->actingAs($member)
        ->put(route('campaigns.hunters.items.store-many', [$this->campaign, $ownHunter]), [
            'items' => [['item_id' => $item->id, 'number' => 2]],
        ])
        ->assertStatus(303);

    expect($ownHunter->items()->find($item->id)->pivot->number)->toBe(2);
});

/*
|--------------------------------------------------------------------------
| Routes outside the resource
|--------------------------------------------------------------------------
|
| `authorizeResource()` only guards the seven resource methods by name. The
| extra actions both controllers declare next to them (potions, days,
| crafting, equipping, item counts, the weapon type page) have to ask the
| policy themselves.
|
*/

test('an outsider cannot change the potions of a campaign', function (): void {
    $this->campaign->update(['health_potions' => 3]);

    $this->actingAs($this->outsider)
        ->put(route('campaigns.update-potions', $this->campaign), ['health_potions' => 0])
        ->assertForbidden();

    expect($this->campaign->fresh()->health_potions)->toBe(3);
});

test('an outsider cannot add or rewrite days of a campaign', function (): void {
    Event::fake(UserMonsterHunted::class);
    $monster = Monster::factory()->create();
    $day = $this->campaign->days()->create(['number' => 1]);
    $hunt = [
        'type_day' => DayType::MONSTER->name,
        'monster_id' => $monster->id,
        'difficulty' => MonsterDifficulty::HARD->name,
        'hunted' => true,
    ];

    $this->actingAs($this->outsider);
    $this->put(route('campaigns.add-day', $this->campaign), $hunt)->assertForbidden();
    $this->put(route('campaigns.update-day', [$this->campaign, $day]), $hunt)->assertForbidden();

    expect($this->campaign->days()->count())->toBe(1)
        ->and($day->fresh()->monster_id)->toBeNull();
    Event::assertNotDispatched(UserMonsterHunted::class);
});

test('a day can only be rewritten through the campaign it belongs to', function (): void {
    $other = Campaign::factory()->create();
    $foreignDay = $other->days()->create(['number' => 1]);

    $this->actingAs($this->owner)
        ->put(route('campaigns.update-day', [$this->campaign, $foreignDay]), [
            'type_day' => DayType::MONSTER->name,
            'monster_id' => Monster::factory()->create()->id,
            'difficulty' => MonsterDifficulty::EASY->name,
        ])
        ->assertNotFound();

    expect($foreignDay->fresh()->monster_id)->toBeNull();
});

test('an outsider cannot craft or equip for somebody else\'s hunter', function (): void {
    Event::fake(UserEquipmentCrafted::class);
    $weapon = Weapon::factory()->create(['is_default' => false]);
    $owned = Weapon::factory()->create(['is_default' => false]);
    $armor = Armor::factory()->create(['is_default' => false]);
    $ownedArmor = Armor::factory()->create(['is_default' => false]);
    $this->hunter->weapons()->attach($owned);
    $this->hunter->armors()->attach($ownedArmor);

    $this->actingAs($this->outsider);
    $this->post(route('campaigns.hunters.weapons.craft', [$this->campaign, $this->hunter, $weapon->type, $weapon]))->assertForbidden();
    $this->put(route('campaigns.hunters.weapons.equip', [$this->campaign, $this->hunter, $owned->type, $owned]), ['equip' => true])->assertForbidden();
    $this->post(route('campaigns.hunters.armors.craft', [$this->campaign, $this->hunter, $armor]))->assertForbidden();
    $this->put(route('campaigns.hunters.armors.equip', [$this->campaign, $this->hunter, $ownedArmor]), ['equip' => true])->assertForbidden();

    expect($this->hunter->weapons()->count())->toBe(1)
        ->and($this->hunter->equippedWeapons()->count())->toBe(0)
        ->and($this->hunter->armors()->count())->toBe(1)
        ->and($this->hunter->equippedArmors()->count())->toBe(0);
    Event::assertNotDispatched(UserEquipmentCrafted::class);
});

test('an outsider cannot set the item count of somebody else\'s hunter', function (): void {
    $item = Item::factory()->create();

    $this->actingAs($this->outsider)
        ->put(route('campaigns.hunters.items.update-count', [$this->campaign, $this->hunter, $item]), ['count_item' => 99])
        ->assertForbidden();

    expect($this->hunter->items()->count())->toBe(0);
});

test('an outsider cannot open the weapon tree of somebody else\'s hunter', function (): void {
    $weapon = Weapon::factory()->create();

    $this->actingAs($this->outsider)
        ->get(route('campaigns.hunters.weapon-type.index', [$this->campaign, $this->hunter, $weapon->type]))
        ->assertForbidden();
});

test('an outsider cannot add a hunter to a campaign', function (): void {
    $this->actingAs($this->outsider);

    $this->get(route('campaigns.hunters.create', $this->campaign))->assertForbidden();
    $this->post(route('campaigns.hunters.store', $this->campaign), ['name' => 'Intruder'])->assertForbidden();

    expect($this->campaign->hunters()->count())->toBe(1);
});

test('any member of the campaign keeps count of the party\'s potions', function (): void {
    $member = User::factory()->create();
    $this->campaign->users()->attach($member, [
        'role_id' => Role::findByName('member-campaign', 'sanctum')->id,
    ]);
    $this->campaign->update(['health_potions' => 3]);

    $this->actingAs($member)
        ->put(route('campaigns.update-potions', $this->campaign), ['health_potions' => 2])
        ->assertStatus(303);

    expect($this->campaign->fresh()->health_potions)->toBe(2);
});

test('the owner of one campaign cannot reach the hunter of another through it', function (): void {
    $foreignHunter = Hunter::factory()->create();
    $item = Item::factory()->create();

    $this->actingAs($this->owner);
    $this->get(route('campaigns.hunters.show', [$this->campaign, $foreignHunter]))->assertForbidden();
    $this->put(route('campaigns.hunters.items.update-count', [$this->campaign, $foreignHunter, $item]), ['count_item' => 9])
        ->assertForbidden();

    expect($foreignHunter->items()->count())->toBe(0);
});
