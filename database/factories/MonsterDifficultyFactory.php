<?php

namespace Database\Factories;

use App\Models\Monster;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enum\MonsterDifficulty as MonsterDifficultyEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MonsterDifficulty>
 */
class MonsterDifficultyFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'monster_id' => Monster::factory(),
            'difficulty' => MonsterDifficultyEnum::EASY,
            'stars' => 1,
            'health' => 50,
            'ability_name' => ['en' => $this->faker->word, 'es' => $this->faker->word],
            'ability_description' => ['en' => $this->faker->sentence, 'es' => $this->faker->sentence],
        ];
    }

    /**
     * `monster_difficulties` has a unique constraint on `[monster_id, difficulty]`,
     * so a plain `->count(N)->create()` would collide on the hardcoded default.
     * Cycling through the enum's cases keeps each one distinct.
     */
    public function configure(): static
    {
        return $this->sequence(
            ['difficulty' => MonsterDifficultyEnum::EASY],
            ['difficulty' => MonsterDifficultyEnum::NORMAL],
            ['difficulty' => MonsterDifficultyEnum::HARD],
        );
    }
}
