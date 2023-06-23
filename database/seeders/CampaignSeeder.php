<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Campaign;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', config('seed.users.admin.email'))->firstOrFail();

        $campaign = Campaign::factory()->create(['team_id' => $user->currentTeam]);
        $campaign->users()->attach($user, [
            'role_id' => Role::findByName('admin-campaign', 'sanctum')->id,
        ]);
    }
}
