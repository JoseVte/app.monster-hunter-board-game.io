<?php

use App\Models\Armor;
use App\Models\Item;
use App\Models\User;
use App\Models\Hunter;
use App\Models\Campaign;
use App\Models\Weapon;

beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
    $this->campaign = Campaign::factory()->create(['team_id' => $this->user->currentTeam->id]);
    $this->hunter = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);
    $this->item = Item::factory()->create();
    $this->weapon = Weapon::factory()->create(['is_default' => false]);
    $this->weaponDefault = Weapon::factory()->create(['is_default' => true]);
    $this->weaponChild = Weapon::factory()->create(['parent_id' => $this->weapon]);
    $this->weaponItem = Weapon::factory()->create(['is_default' => false]);
    $this->weaponItem->items()->attach($this->item, ['number' => 1]);

    $this->armor = Armor::factory()->create(['is_default' => false]);
    $this->armorDefault = Armor::factory()->create(['is_default' => true]);
    $this->armorItem = Armor::factory()->create(['is_default' => false]);
    $this->armorItem->items()->attach($this->item, ['number' => 1]);
});

test('hunter can see edit page', function (): void {
    $response = $this->get(route('campaigns.hunters.edit', [$this->campaign, $this->hunter]));
    $response->assertStatus(200);
});

test('hunter can update', function (): void {
    $response = $this->put(route('campaigns.hunters.update', [$this->campaign, $this->hunter]), [
        'name' => 'Test Hunter',
    ]);
    $response->assertStatus(303);

    $this->hunter->refresh();
    $this->assertEquals('Test Hunter', $this->hunter->name);
});

test('hunter can update common items', function (): void {
    $response = $this->put(route('campaigns.hunters.items.update-count', [$this->campaign, $this->hunter, $this->item]), [
        'count_item' => 10,
    ]);
    $response->assertStatus(303);

    $this->assertEquals(1, $this->hunter->items()->count());
    $this->assertEquals(10, $this->hunter->items()->first()->pivot->number);
});

test('hunter can craft weapon', function (): void {
    $response = $this->post(route('campaigns.hunters.weapons.craft', [$this->campaign, $this->hunter, $this->weapon->type, $this->weapon]));
    $response->assertStatus(303);

    $this->assertEquals(1, $this->hunter->weapons()->count());
});

test('hunter cannot craft default weapon', function (): void {
    $response = $this->post(route('campaigns.hunters.weapons.craft', [$this->campaign, $this->hunter, $this->weaponDefault->type, $this->weaponDefault]));
    $response->assertStatus(400);

    $this->assertEquals(0, $this->hunter->weapons()->count());
});

test('hunter cannot craft child weapon without previous weapon', function (): void {
    $response = $this->post(route('campaigns.hunters.weapons.craft', [$this->campaign, $this->hunter, $this->weaponChild->type, $this->weaponChild]));
    $response->assertStatus(400);

    $this->assertEquals(0, $this->hunter->weapons()->count());
});

test('hunter can craft child weapon', function (): void {
    $this->hunter->weapons()->attach($this->weapon);
    $response = $this->post(route('campaigns.hunters.weapons.craft', [$this->campaign, $this->hunter, $this->weaponChild->type, $this->weaponChild]));
    $response->assertStatus(303);

    $this->assertEquals(1, $this->hunter->weapons()->count());
});

test('hunter can craft weapon with items', function (): void {
    $this->hunter->items()->attach($this->item, ['number' => 1]);
    $response = $this->post(route('campaigns.hunters.weapons.craft', [$this->campaign, $this->hunter, $this->weaponItem->type, $this->weaponItem]));
    $response->assertStatus(303);

    $this->assertEquals(1, $this->hunter->weapons()->count());
    $this->assertEquals(1, $this->hunter->items()->count());
    $this->assertEquals(0, $this->hunter->items()->find($this->item)->pivot->number);
});

test('hunter cannot craft weapon without items', function (): void {
    $response = $this->post(route('campaigns.hunters.weapons.craft', [$this->campaign, $this->hunter, $this->weaponItem->type, $this->weaponItem]));
    $response->assertStatus(400);

    $this->assertEquals(0, $this->hunter->weapons()->count());
});

test('hunter can craft armor', function (): void {
    $response = $this->post(route('campaigns.hunters.armors.craft', [$this->campaign, $this->hunter, $this->armor]));
    $response->assertStatus(303);

    $this->assertEquals(1, $this->hunter->armors()->count());
});

test('hunter cannot craft default armor', function (): void {
    $response = $this->post(route('campaigns.hunters.armors.craft', [$this->campaign, $this->hunter, $this->armorDefault]));
    $response->assertStatus(400);

    $this->assertEquals(0, $this->hunter->armors()->count());
});

test('hunter can craft armor with items', function (): void {
    $this->hunter->items()->attach($this->item, ['number' => 1]);
    $response = $this->post(route('campaigns.hunters.armors.craft', [$this->campaign, $this->hunter, $this->armorItem]));
    $response->assertStatus(303);

    $this->assertEquals(1, $this->hunter->armors()->count());
    $this->assertEquals(1, $this->hunter->items()->count());
    $this->assertEquals(0, $this->hunter->items()->find($this->item)->pivot->number);
});

test('hunter cannot craft armor without items', function (): void {
    $response = $this->post(route('campaigns.hunters.armors.craft', [$this->campaign, $this->hunter, $this->armorItem]));
    $response->assertStatus(400);

    $this->assertEquals(0, $this->hunter->armors()->count());
});

test('hunter can equip armor owned', function (): void {
    $this->hunter->armors()->attach($this->armor);
    $response = $this->put(route('campaigns.hunters.armors.equip', [$this->campaign, $this->hunter, $this->armor]), ['equip' => true]);
    $response->assertStatus(303);

    $this->assertEquals(1, $this->hunter->armors()->count());
    $this->assertEquals(1, $this->hunter->equippedArmors()->count());
});

test('hunter can equip armor owned and unequip old', function (): void {
    $this->hunter->armors()->attach($this->armor);
    $this->hunter->armors()->attach($this->armorDefault, ['equip' => true]);
    $response = $this->put(route('campaigns.hunters.armors.equip', [$this->campaign, $this->hunter, $this->armor]), ['equip' => true]);
    $response->assertStatus(303);

    $this->assertEquals(2, $this->hunter->armors()->count());
    $this->assertEquals(1, $this->hunter->equippedArmors()->count());
    $this->assertEquals($this->armor->id, $this->hunter->equippedArmors()->first()->id);
});

test('hunter cannot equip armor no owned', function (): void {
    $response = $this->put(route('campaigns.hunters.armors.equip', [$this->campaign, $this->hunter, $this->armor]), ['equip' => true]);
    $response->assertStatus(400);

    $this->assertEquals(0, $this->hunter->armors()->count());
    $this->assertEquals(0, $this->hunter->equippedArmors()->count());
});

test('hunter can unequip armor owned', function (): void {
    $this->hunter->armors()->attach($this->armor, ['equip' => true]);
    $response = $this->put(route('campaigns.hunters.armors.equip', [$this->campaign, $this->hunter, $this->armor]), ['equip' => false]);
    $response->assertStatus(303);

    $this->assertEquals(1, $this->hunter->armors()->count());
    $this->assertEquals(0, $this->hunter->equippedArmors()->count());
});

test('hunter cannot unequip armor no owned', function (): void {
    $response = $this->put(route('campaigns.hunters.armors.equip', [$this->campaign, $this->hunter, $this->armor]), ['equip' => false]);
    $response->assertStatus(400);

    $this->assertEquals(0, $this->hunter->armors()->count());
    $this->assertEquals(0, $this->hunter->equippedArmors()->count());
});
