<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::where('email', config('seed.users.admin.email'))->doesntExist()) {
            $user = User::factory()->withPersonalTeam()->create([
                'name' => config('seed.users.admin.name'),
                'email' => config('seed.users.admin.email'),
                'password' => bcrypt(config('seed.users.admin.password')),
            ]);

            $user->assignRole('admin');

            $personalTeam = $user->currentTeam;

            User::factory(3)->create()->each(function (User $user) use ($personalTeam) {
                $personalTeam->users()->attach(
                    $user,
                    ['role' => 'editor']
                );
            });
        }
    }
}
