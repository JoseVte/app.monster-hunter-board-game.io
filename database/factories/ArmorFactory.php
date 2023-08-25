<?php

namespace Database\Factories;

use App\Enum\ArmorType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Armor>
 */
class ArmorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(ArmorType::cases())->name,
            'name' => [
                'en' => $this->faker->name,
                'es' => $this->faker->name,
            ],
        ];
    }
}
