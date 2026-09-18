<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Monster;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MonsterReward>
 */
class MonsterRewardFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'monster_id' => Monster::factory(),
            'roll' => $this->faker->numberBetween(1, 12),
            'item_id' => Item::factory(),
            'extra' => [],
        ];
    }

    /**
     * `monster_rewards` has a unique constraint on `[monster_id, roll]`, and a
     * random roll collides by birthday-paradox chance well before 12 rewards.
     * Cycling 1 through 12 by the sequence's own index rules that out.
     */
    public function configure(): static
    {
        return $this->sequence(
            fn (Sequence $sequence): array => ['roll' => ($sequence->index % 12) + 1],
        );
    }
}
