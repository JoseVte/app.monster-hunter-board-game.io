<?php

use Illuminate\Support\Facades\File;

// Google asks for the badge or a visible attribution, one of the two.
// resources/js/recaptcha.js keeps the badge hidden, so the attribution is the
// only thing holding up that end, and it lives in a component a new form can
// simply forget. Nothing about forgetting it is visible: the form works, the
// captcha works, and the terms quietly stop being met.
test('every form that runs recaptcha shows the attribution Google asks for', function (): void {
    $forms = collect(File::allFiles(resource_path('js')))
        ->filter(fn (SplFileInfo $file): bool => $file->getExtension() === 'vue')
        ->filter(fn (SplFileInfo $file): bool => str_contains(File::get($file->getPathname()), 'useRecaptcha('));

    expect($forms)->not->toBeEmpty('Nothing calls useRecaptcha any more; this test is watching nothing.');

    $missing = $forms
        ->reject(fn (SplFileInfo $file): bool => str_contains(File::get($file->getPathname()), 'RecaptchaNotice'))
        ->map(fn (SplFileInfo $file): string => $file->getFilename())
        ->values()
        ->all();

    expect($missing)->toBe([]);
});
