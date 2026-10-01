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

        // `downtime-activities.php` used to be a flat list of activities and is
        // now keyed, with `activities` alongside `rules` (how downtime works at
        // all) and `extra` (what an expansion changes about it). Only the
        // activities have a table to go in; the other two are data waiting for
        // somewhere to be shown, so reading the whole file here would hand this
        // loop an array of activities where it expects one activity.
        foreach (SeedData::get('downtime-activities.activities') as $activity) {
            $seeded[] = $activity['name']['en'];

            DowntimeActivity::updateOrCreate([
                'name->en' => $activity['name']['en'],
            ], $activity);
        }

        $this->pruneMissing(DowntimeActivity::class, $seeded, 'downtime activities');
    }
}
