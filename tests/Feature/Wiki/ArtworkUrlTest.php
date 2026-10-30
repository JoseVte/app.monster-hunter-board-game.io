<?php

use App\Models\Item;
use App\Models\User;
use App\Models\Monster;
use App\Models\WeaponType;
use App\Models\MonsterPart;
use App\Models\MonsterDifficulty;
use Inertia\Testing\AssertableInertia;
use Illuminate\Support\Facades\Storage;

// Items, monsters and weapon types each carry a picture that may be a full URL
// (seeded from the game's assets), a file on the app's disk, or nothing, in
// which case the initials of the English name stand in for it.

dataset('artwork', [
    'item' => [fn () => Item::factory()->create(['name' => ['en' => 'Monster Bone Plus', 'es' => 'Hueso']]), 'icon_path', 'icon_url'],
    'monster' => [fn () => Monster::factory()->create(['name' => ['en' => 'Great Jagras', 'es' => 'Gran Jagras']]), 'icon_path', 'icon_url'],
    'weapon type' => [fn () => WeaponType::factory()->create(['name' => ['en' => 'Charge Blade', 'es' => 'Hacha cargada']]), 'image_path', 'image_url'],
]);

beforeEach(function (): void {
    Storage::fake('public');
    config(['jetstream.profile_photo_disk' => 'public']);
});

test('a full URL is used as it is', function (Closure $make, string $path, string $url): void {
    $model = $make();
    $model->forceFill([$path => 'https://cdn.example.com/art.png'])->save();

    expect($model->fresh()->{$url})->toBe('https://cdn.example.com/art.png');
})->with('artwork');

test('a stored file is served from the public disk', function (Closure $make, string $path, string $url): void {
    $model = $make();
    $model->forceFill([$path => 'art/piece.png'])->save();

    expect($model->fresh()->{$url})->toBe(Storage::disk('public')->url('art/piece.png'));
})->with('artwork');

test('without a picture the initials of the name stand in', function (Closure $make, string $path, string $url): void {
    $model = $make();
    $initials = collect(explode(' ', $model->getTranslation('name', 'en')))->map(fn (string $word): string => $word[0])->join(' ');

    expect($model->{$url})
        ->toStartWith('https://ui-avatars.com/api/?name=')
        ->toContain('name='.urlencode($initials).'&');
})->with('artwork');

test('the monster card page carries every difficulty with its parts', function (): void {
    $this->actingAs(User::factory()->withPersonalTeam()->create());
    $monster = Monster::factory()->create();
    $difficulty = MonsterDifficulty::factory()->create(['monster_id' => $monster->id]);
    MonsterPart::factory()->count(2)->create(['monster_difficulty_id' => $difficulty->id]);

    $this->get(route('wiki.monster.card', $monster))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Wiki/Monster/Card')
            ->where('monster.id', $monster->id)
            ->has('monster.difficulties', 1)
            ->has('monster.difficulties.0.parts', 2));
});
