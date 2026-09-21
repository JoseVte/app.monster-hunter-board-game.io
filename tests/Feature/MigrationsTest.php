<?php

use Illuminate\Support\Facades\File;

// `migrate:refresh` rolls every migration back before running it again. A
// migration with no `down()` is skipped silently on the way back, so its tables
// survive, and the next migration to try dropping something they reference
// fails. Six of them had none, and dropping `weapons` died on a foreign key
// from `weapon_recipes` that nothing was ever going to remove.
//
// This catches a missing `down()`, which is the mistake that was actually made.
// It cannot catch one that does the wrong thing or undoes it in an order the
// foreign keys refuse, and sqlite would not report that anyway; for those, run
// `migrate:refresh` against MySQL.
test('every migration says how to roll itself back', function (): void {
    $missing = collect(File::files(database_path('migrations')))
        ->reject(fn (SplFileInfo $file): bool => str_contains(File::get($file->getPathname()), 'function down'))
        ->map(fn (SplFileInfo $file): string => $file->getFilename())
        ->values()
        ->all();

    expect($missing)->toBe([]);
});
