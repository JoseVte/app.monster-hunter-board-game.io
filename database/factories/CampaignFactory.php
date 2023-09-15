<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\Campaign;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'max_days' => $this->faker->numberBetween(40, 60),
        ];
    }

    public function configure(): self
    {
        return $this->afterCreating(function (Campaign $campaign) {
            $campaign->users()->attach($campaign->team->owner, [
                'role_id' => Role::findByName('admin-campaign', 'sanctum')->id,
            ]);

            return $campaign;
        });
    }
}
