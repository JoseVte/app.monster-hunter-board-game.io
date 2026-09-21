<?php

namespace Database\Seeders\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

trait PrunesRemovedEntries
{
    /**
     * Delete the rows the data files no longer name.
     *
     * Every content seeder matches on `name->en`, so renaming an entry creates
     * a row rather than renaming one and the old one lives on: unreferenced by
     * the data, still listed in the wiki, and impossible to tell apart from a
     * real entry without reading the seed files.
     *
     * **A row something still points at is kept, not forced.** Deleting an item
     * a hunter is carrying is data loss, and the foreign key refuses it anyway.
     * The delete is attempted one row at a time precisely so that one refusal
     * does not abandon the rest of the seed, and what survived is reported
     * rather than passed over in silence.
     *
     * @param  class-string<Model>  $model
     * @param  list<string>  $keep  every English name the data still declares
     */
    protected function pruneMissing(string $model, array $keep, string $label): void
    {
        $orphans = $model::query()->whereNotIn('name->en', $keep)->get();

        if ($orphans->isEmpty()) {
            return;
        }

        $held = [];

        foreach ($orphans as $orphan) {
            try {
                $orphan->delete();
            } catch (QueryException) {
                $held[] = $orphan->name;
            }
        }

        $removed = $orphans->count() - count($held);

        if ($removed > 0) {
            $this->command?->info("Removed {$removed} {$label} the data no longer names.");
        }

        if ($held !== []) {
            $this->command?->warn(
                'Kept '.count($held).' '.$label.' that something still points at: '.implode(', ', $held).'.'
            );
        }
    }
}
