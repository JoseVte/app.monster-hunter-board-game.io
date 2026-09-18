<?php

use App\Models\Item;
use App\Models\User;
use App\Models\Armor;
use App\Enum\ItemType;
use App\Models\Hunter;
use App\Models\Weapon;
use App\Enum\ArmorType;
use App\Models\Monster;
use App\Models\Campaign;
use App\Models\WeaponType;
use Inertia\Testing\AssertableInertia;

beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
    $this->campaign = Campaign::factory()->create(['team_id' => $this->user->currentTeam->id]);
    $this->hunter = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);
});

test('hunter show renders the items tab by default', function (): void {
    $response = $this->get(route('campaigns.hunters.show', [$this->campaign, $this->hunter]));

    $response->assertStatus(200);
    $response->assertInertia(
        fn (AssertableInertia $page) => $page
            ->component('Hunter/Show')
            ->where('hunter.id', $this->hunter->id)
            ->where('campaign.id', $this->campaign->id)
            ->where('tabOpened', 'items')
            ->where('weaponType', null)
            ->has('commonItems')
            ->has('otherItems')
            ->has('monsterItems')
            ->has('weaponTypes')
            ->has('armors')
    );
});

test('hunter show groups the items by type', function (): void {
    Item::factory()->create(['type' => ItemType::COMMON->name]);
    Item::factory()->count(2)->create(['type' => ItemType::OTHER->name]);
    Item::factory()->count(3)->create(['type' => ItemType::MONSTER_PART->name]);

    $response = $this->get(route('campaigns.hunters.show', [$this->campaign, $this->hunter]));

    $response->assertInertia(
        fn (AssertableInertia $page) => $page
            ->has('commonItems', 1)
            ->has('otherItems', 2)
            // The monster parts come grouped, and these three belong to no
            // monster, so they land in the one group for the rest.
            ->has('monsterItems', 1)
            ->has('monsterItems.0.items', 3)
    );
});

test('hunter show opens the weapons and armors tabs', function (string $tab): void {
    $response = $this->get(route('campaigns.hunters.show', [$this->campaign, $this->hunter, $tab]));

    $response->assertStatus(200);
    $response->assertInertia(fn (AssertableInertia $page) => $page->where('tabOpened', $tab));
})->with(['items', 'weapons', 'armors']);

test('hunter show rejects an unknown tab', function (): void {
    $response = $this->get("/campaigns/{$this->campaign->id}/hunters/{$this->hunter->id}/potions");

    $response->assertStatus(404);
});

test('hunter show builds the weapon tree for a weapon type', function (): void {
    $weaponType = WeaponType::factory()->create();
    $default = Weapon::factory()->create(['type_id' => $weaponType->id, 'is_default' => true]);
    Weapon::factory()->create(['type_id' => $weaponType->id, 'parent_id' => $default->id]);

    $response = $this->get(route('campaigns.hunters.weapon-type.index', [$this->campaign, $this->hunter, $weaponType]));

    $response->assertStatus(200);
    $response->assertInertia(
        fn (AssertableInertia $page) => $page
            ->where('tabOpened', 'weapons')
            ->where('weaponType.id', $weaponType->id)
            ->has('weapons')
    );
});

test('hunter show flags which armors can be crafted', function (): void {
    $item = Item::factory()->create();
    $craftable = Armor::factory()->create(['is_default' => false]);
    $craftable->items()->attach($item, ['number' => 1]);
    $this->hunter->items()->attach($item, ['number' => 1]);

    $tooExpensive = Armor::factory()->create(['is_default' => false]);
    $tooExpensive->items()->attach($item, ['number' => 5]);

    $response = $this->get(route('campaigns.hunters.show', [$this->campaign, $this->hunter, 'armors']));

    $response->assertStatus(200);
    expect($this->hunter->fresh()->canCraftArmor($craftable))->toBeTrue()
        ->and($this->hunter->fresh()->canCraftArmor($tooExpensive))->toBeFalse();
});

test('hunter show marks the owner as able to edit', function (): void {
    $response = $this->get(route('campaigns.hunters.show', [$this->campaign, $this->hunter]));

    $response->assertInertia(fn (AssertableInertia $page) => $page->where('canEdit', true));
});

test('hunter show is not reachable by a user outside the campaign', function (): void {
    $this->actingAs(User::factory()->withPersonalTeam()->create());

    $response = $this->get(route('campaigns.hunters.show', [$this->campaign, $this->hunter]));

    $response->assertStatus(403);
});

test('hunter show groups the armors by the monster they come from', function (): void {
    // The tab lines the three slots up in a row per monster, so the piece for
    // each slot has to be reachable by branch and then by slot.
    Armor::factory()->create(['branch' => 'Rathalos', 'type' => ArmorType::HEAD]);
    Armor::factory()->create(['branch' => 'Rathalos', 'type' => ArmorType::BODY]);
    Armor::factory()->create(['branch' => 'Rathalos', 'type' => ArmorType::LEG]);

    $response = $this->get(route('campaigns.hunters.show', [$this->campaign, $this->hunter, 'armors']));

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->has('armors.Rathalos.head')
        ->has('armors.Rathalos.body')
        ->has('armors.Rathalos.leg')
        ->where('armors.Rathalos.head.branch', 'Rathalos'));
});

test('hunter show groups the monster parts under the monster they drop from', function (): void {
    $jagras = Monster::factory()->create(['name' => ['en' => 'Great Jagras', 'es' => 'Gran Jagras']]);
    $hide = Item::factory()->create(['type' => ItemType::MONSTER_PART->name]);
    $jagras->items()->attach($hide);

    // Belongs to no monster, so it goes in the group for the rest.
    Item::factory()->create(['type' => ItemType::MONSTER_PART->name]);

    $response = $this->get(route('campaigns.hunters.show', [$this->campaign, $this->hunter]));

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->has('monsterItems', 2)
        ->where('monsterItems.0.monster', $jagras->name)
        ->has('monsterItems.0.items', 1)
        ->has('monsterItems.1.items', 1));
});
