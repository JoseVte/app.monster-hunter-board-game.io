<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DowntimeActivity;
use Database\Seeders\Concerns\PrunesRemovedEntries;

class DowntimeActivitiesSeeder extends Seeder
{
    use PrunesRemovedEntries;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeded = [];

        foreach (SeedData::get('downtime-activities') as $activity) {
            $seeded[] = $activity['name']['en'];

            DowntimeActivity::updateOrCreate([
                'name->en' => $activity['name']['en'],
            ], $activity);
        }

        $this->pruneMissing(DowntimeActivity::class, $seeded, 'downtime activities');
    }
}
