<?php

namespace Database\Factories;

use App\Models\Weapon;
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

    /**
     * Every seeded weapon has at least one recipe, since that is what says how it
     * is made and from which monster. A weapon without one cannot be crafted at
     * all, so a factory that skipped it would build something the app never sees.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Weapon $weapon): void {
            $weapon->recipes()->create(['position' => 0]);
        });
    }
}
