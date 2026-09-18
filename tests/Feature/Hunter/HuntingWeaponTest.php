<?php

use App\Models\User;
use App\Models\Hunter;
use App\Models\Weapon;
use App\Models\Campaign;
use App\Models\WeaponType;

beforeEach(function (): void {
    $this->actingAs($this->user = User::factory()->withPersonalTeam()->create());
    $this->campaign = Campaign::factory()->create(['team_id' => $this->user->currentTeam->id]);
    $this->hunter = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);

    $this->sword = WeaponType::factory()->create();
    $this->bow = WeaponType::factory()->create();

    $this->hunt = fn (WeaponType $type) => $this->put(
        route('campaigns.hunters.weapon-type.hunt', [$this->campaign, $this->hunter, $type]),
    );
});

test('a hunter starts out carrying the great sword', function (): void {
    // The rulebook starts everyone on it, and a hunter always has something in
    // hand, so there is no state where nothing is carried.
    $greatSword = WeaponType::factory()->create(['name' => ['en' => 'Great Sword', 'es' => 'Gran Espada']]);

    $hunter = Hunter::factory()->create(['campaign_id' => $this->campaign->id]);

    expect($hunter->weaponType->id)->toBe($greatSword->id);
});

test('a hunter picks the weapon type they hunt with', function (): void {
    ($this->hunt)($this->sword)->assertStatus(303);

    expect($this->hunter->fresh()->weaponType->id)->toBe($this->sword->id);
});

test('picking a second weapon type replaces the first, since only one is carried', function (): void {
    ($this->hunt)($this->sword);
    ($this->hunt)($this->bow)->assertStatus(303);

    expect($this->hunter->fresh()->weaponType->id)->toBe($this->bow->id);
});

test('picking the type already carried leaves it carried', function (): void {
    // A hunter cannot go out empty handed, so there is nothing to put down.
    ($this->hunt)($this->sword);
    ($this->hunt)($this->sword)->assertStatus(303);

    expect($this->hunter->fresh()->weaponType->id)->toBe($this->sword->id);
});

test('the weapon equipped within a type is left alone', function (): void {
    // The two are separate: a hunter keeps a favourite of every type and carries
    // one of those types into the hunt.
    $weapon = Weapon::factory()->create(['type_id' => $this->sword->id]);
    $this->hunter->weapons()->attach($weapon, ['equipped' => true]);

    ($this->hunt)($this->bow);

    expect($this->hunter->fresh()->equippedWeapons->pluck('id'))->toContain($weapon->id);
});

test('a hunter outside the campaign cannot pick', function (): void {
    $this->actingAs(User::factory()->withPersonalTeam()->create());

    ($this->hunt)($this->sword)->assertStatus(403);
});
