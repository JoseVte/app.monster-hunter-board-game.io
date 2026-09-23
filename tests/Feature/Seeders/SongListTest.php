<?php

use App\Models\Song;
use App\Models\Weapon;
use App\Models\SongList;
use App\Models\SongEffect;
use App\Models\WeaponType;
use Database\Seeders\ItemsSeeder;
use Database\Seeders\WeaponsSeeder;

/**
 * A hunting horn plays from one of ten song lists, and which list is printed on
 * its weapon card. Both the lists and the effects they call on sat in the seed
 * data from the start with nothing reading them.
 */
beforeEach(function (): void {
    $this->seed(ItemsSeeder::class);
    $this->seed(WeaponsSeeder::class);
});

test('every song effect in the data is seeded with its rules text', function (): void {
    expect(SongEffect::count())->toBe(11);

    $attack = SongEffect::where('name->en', 'Attack Up')->firstOrFail();

    expect($attack->getTranslation('name', 'es'))->toBe('Ataque Mejorado')
        ->and($attack->description)->toContain(':damage_attack_icon:');
});

test('a song list belongs to the weapon type that plays it', function (): void {
    $ore = SongList::where('name->en', 'Ore Song List')->firstOrFail();

    expect($ore->weaponType->getTranslation('name', 'en'))->toBe('Hunting Horn')
        ->and(SongList::count())->toBe(10);
});

test('a song carries the notes it is played with, in order', function (): void {
    $ore = SongList::where('name->en', 'Ore Song List')->firstOrFail();

    expect($ore->songs->pluck('notes')->all())->toBe([
        ['white', 'white'],
        ['white', 'red', 'red'],
        ['white', 'blue', 'blue'],
    ]);
});

test('a song names the effect it plays and the range it reaches', function (): void {
    $ore = SongList::where('name->en', 'Ore Song List')->firstOrFail();
    $attack = $ore->songs->firstWhere('range', 1);

    expect($attack->effect->getTranslation('name', 'en'))->toBe('Attack Up')
        ->and($ore->songs->first()->range)->toBe(0);
});

test('a hunting horn points at the list printed on its card', function (): void {
    $bagpipe = Weapon::where('name->en', 'Metal Bagpipe')->firstOrFail();

    expect($bagpipe->songList->getTranslation('name', 'en'))->toBe('Ore Song List');
});

test('a weapon of any other type points at no list', function (): void {
    expect(Weapon::where('name->en', 'Iron Bow')->firstOrFail()->song_list_id)->toBeNull();
});

test('seeding twice leaves one of everything', function (): void {
    $this->seed(WeaponsSeeder::class);

    expect(SongEffect::count())->toBe(11)
        ->and(SongList::count())->toBe(10)
        ->and(Song::count())->toBe(SongList::withCount('songs')->get()->sum('songs_count'));
});

test('the horn is the only type that carries lists', function (): void {
    expect(WeaponType::whereHas('songLists')->count())->toBe(1);
});
