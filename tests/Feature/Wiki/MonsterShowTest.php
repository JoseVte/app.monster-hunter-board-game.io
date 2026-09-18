<?php

use App\Models\Item;
use App\Models\User;
use App\Models\Monster;
use App\Models\MonsterPart;
use App\Models\MonsterReward;
use App\Models\MonsterDifficulty;
use Inertia\Testing\AssertableInertia;
use App\Enum\MonsterDifficulty as MonsterDifficultyEnum;

beforeEach(function (): void {
    $this->actingAs(User::factory()->withPersonalTeam()->create());

    $this->monster = Monster::factory()->create([
        'resistance_fire' => 1,
        'resistance_water' => null,
    ]);
});

test('a monster shows its difficulty tiers and body-part breaks', function (): void {
    $tier = MonsterDifficulty::factory()->for($this->monster)->create([
        'difficulty' => MonsterDifficultyEnum::EASY,
        'stars' => 1,
        'health' => 50,
    ]);
    MonsterPart::factory()->for($tier, 'difficulty')->create(['icon' => 'head']);

    $this->get(route('wiki.monster.show', $this->monster))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('monster.difficulties', 1)
            ->where('monster.difficulties.0.stars', 1)
            ->has('monster.difficulties.0.parts', 1)
            ->where('monster.difficulties.0.parts.0.icon', 'head'));
});

test('a monster shows its resistances', function (): void {
    $this->get(route('wiki.monster.show', $this->monster))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('monster.resistance_fire', 1)
            ->where('monster.resistance_water', null));
});

test('a monster shows its reward table', function (): void {
    $item = Item::factory()->create();
    MonsterReward::factory()->for($this->monster)->create(['roll' => 1, 'item_id' => $item->id]);

    $this->get(route('wiki.monster.show', $this->monster))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('monster.rewards', 1)
            ->where('monster.rewards.0.roll', 1)
            ->where('monster.rewards.0.item.id', $item->id));
});

test('a monster without setup or mechanics shows neither', function (): void {
    // Unlike the seeder (which writes an empty array for a monster that
    // declares neither, see Task 1), the factory never touches these columns
    // at all, so the raw value is a genuine SQL NULL here.
    $this->get(route('wiki.monster.show', $this->monster))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->where('monster.setup', null)
            ->where('monster.mechanics', []));
});
