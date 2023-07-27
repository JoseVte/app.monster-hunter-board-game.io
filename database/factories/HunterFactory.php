<?php

namespace Database\Factories;

use App\Models\Hunter;
use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hunter>
 */
class HunterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'campaign_id' => Campaign::factory(),
            'name' => $this->faker->name,
        ];
    }

    public function configure(): self
    {
        return $this->afterCreating(function (Hunter $hunter) {
            $campaign = $hunter->campaign;
            if ($campaign->users()->find($campaign->team->owner) === null) {
                $campaign->users()->attach($campaign->team->owner, [
                    'role_id' => Role::findByName('member-campaign', 'sanctum')->id,
                ]);
            }
            $campaign->users()->updateExistingPivot($campaign->team->owner, ['hunter_id' => $hunter->id]);

            return $hunter;
        });
    }
}
