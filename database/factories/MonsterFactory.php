<?php

namespace Database\Factories;

use App\Enum\MonsterCategory;
use App\Enum\MonsterExpansion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Monster>
 */
class MonsterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => [
                'en' => $this->faker->name,
                'es' => $this->faker->name,
            ],
            'category' => $this->faker->randomElement(MonsterCategory::cases()),
            'expansion' => $this->faker->randomElement(MonsterExpansion::cases()),
        ];
    }
}
