<?php

use App\Models\Armor;
use App\Models\Weapon;

test('a name is found in the language it was typed in', function (): void {
    Weapon::factory()->create(['name' => ['en' => 'Buster Sword', 'es' => 'Espada Cazadora']]);
    Weapon::factory()->create(['name' => ['en' => 'Iron Katana', 'es' => 'Katana Férrea']]);

    expect(Weapon::whereNameLike('Buster')->count())->toBe(1)
        ->and(Weapon::whereNameLike('Cazadora')->count())->toBe(1);
});

test('the search does not care about case', function (): void {
    Weapon::factory()->create(['name' => ['en' => 'Buster Sword', 'es' => 'Espada Cazadora']]);

    expect(Weapon::whereNameLike('buster')->count())->toBe(1)
        ->and(Weapon::whereNameLike('BUSTER')->count())->toBe(1);
});

test('an empty search leaves the list alone', function (): void {
    Weapon::factory()->count(3)->create();

    expect(Weapon::whereNameLike(null)->count())->toBe(3)
        ->and(Weapon::whereNameLike('   ')->count())->toBe(3);
});

test('the scope reaches armours too', function (): void {
    Armor::factory()->create(['name' => ['en' => 'Anja Helm', 'es' => 'Yelmo de Anja']]);
    Armor::factory()->create(['name' => ['en' => 'Bone Helm', 'es' => 'Yelmo de Hueso']]);

    expect(Armor::whereNameLike('Yelmo de Anja')->count())->toBe(1);
});

test('a search that matches nothing comes back empty', function (): void {
    Weapon::factory()->create(['name' => ['en' => 'Buster Sword', 'es' => 'Espada Cazadora']]);

    expect(Weapon::whereNameLike('Nergigante')->count())->toBe(0);
});

test('every wiki detail route the search links to renders', function (): void {
    // The searchable index and the results page both build these, and Ziggy
    // throws on a route it does not know, which takes the page with it.
    $this->actingAs(App\Models\User::factory()->withPersonalTeam()->create());

    $weapon = Weapon::factory()->create();
    $armor = Armor::factory()->create();
    $item = App\Models\Item::factory()->create();

    $this->get(route('wiki.weapon.show', $weapon))->assertStatus(200);
    $this->get(route('wiki.armor.show', $armor))->assertStatus(200);
    $this->get(route('wiki.item.show', $item))->assertStatus(200);
});
