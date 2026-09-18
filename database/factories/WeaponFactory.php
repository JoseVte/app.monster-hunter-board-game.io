<?php

namespace Database\Factories;

use App\Models\WeaponType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Weapon>
 */
class WeaponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_id' => WeaponType::factory(),
            'rarity' => $this->faker->numberBetween(1, 8),
            'name' => [
                'en' => $this->faker->name,
                'es' => $this->faker->name,
            ],
        ];
    }
}
