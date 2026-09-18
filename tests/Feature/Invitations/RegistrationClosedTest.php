<?php

use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;

test('the register route only exists while registration is open', function (): void {
    expect(Route::has('register'))->toEqual(Features::enabled(Features::registration()));
});

test('every page is told whether to offer a way to sign up', function (): void {
    // Shared, not passed per page. Login used to hardcode it to true, so with
    // registration closed it rendered a link to a route Ziggy could not resolve,
    // and the thrown error took the whole Vue mount down: a blank page, and
    // nothing in the console that a body-text check would notice.
    foreach (['/', '/login', '/forgot-password'] as $path) {
        $this->get($path)->assertInertia(
            fn ($page) => $page->where('canRegister', Route::has('register')),
        );
    }
});

test('no page offers a link to registration while it is closed', function (): void {
    if (Features::enabled(Features::registration())) {
        $this->markTestSkipped('Registration is open, so the links belong there.');
    }

    expect(Route::has('register'))->toBeFalse();

    // The one template that hardcoded it. Anything reading the shared prop is
    // covered by the test above.
    expect(file_get_contents(resource_path('js/Pages/Auth/Login.vue')))
        ->not->toContain(':can-register="true"');
});
