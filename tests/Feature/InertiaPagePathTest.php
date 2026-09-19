<?php

// Inertia resolves an asserted page component against `inertia.pages.paths`,
// and the package default is `resource_path('js/pages')`, lowercase, while this
// project has always kept `resources/js/Pages`. A case-insensitive filesystem
// hides that: every assertInertia passes on macOS and every one of them fails on
// the Linux CI runner with "Inertia page component file [...] does not exist".
//
// Comparing against scandir rather than calling is_dir is the whole point. is_dir
// answers yes to the wrong case on the machine where this is most likely to be
// written, so it would pin nothing.
test('every configured inertia page path exists with the case the filesystem stores', function (): void {
    $paths = config('inertia.pages.paths');

    expect($paths)->not->toBeEmpty();

    foreach ($paths as $path) {
        expect(scandir(dirname($path)))->toContain(basename($path));
    }
});
