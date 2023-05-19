<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DowntimeActivity;

class DowntimeActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('seeders.downtime-activities') as $activity) {
            DowntimeActivity::create($activity);
        }
    }
}
