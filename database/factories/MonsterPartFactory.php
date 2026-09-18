<?php

namespace Database\Factories;

use App\Models\MonsterDifficulty;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MonsterPart>
 */
class MonsterPartFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'monster_difficulty_id' => MonsterDifficulty::factory(),
            'icon' => 'head',
            'direction' => 'up',
            'defense' => 0,
            'broken' => 3,
            'ability_broken' => [],
            'position' => 0,
        ];
    }

    /**
     * `monster_parts` has a unique constraint on `[monster_difficulty_id, position]`,
     * so a plain `->count(N)->create()` would collide on the hardcoded default.
     * The sequence's own index gives each part a distinct position.
     */
    public function configure(): static
    {
        return $this->sequence(
            fn (Sequence $sequence): array => ['position' => $sequence->index],
        );
    }
}
