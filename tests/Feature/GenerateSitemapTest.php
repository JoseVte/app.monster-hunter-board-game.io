<?php

use Illuminate\Support\Facades\File;

// The command asked the URL generator for route('register') unconditionally,
// and that route only exists while AUTH_CAN_REGISTER is on, which it is not by
// default. It threw RouteNotFoundException and wrote nothing at all.
test('the sitemap is generated while registration is closed', function (): void {
    expect(Route::has('register'))->toBeFalse();

    $this->artisan('generate:sitemap')->assertSuccessful();

    $sitemap = File::get(public_path('sitemap.xml'));

    expect($sitemap)
        ->toContain(route('welcome'))
        ->toContain(route('login'))
        ->toContain(route('policy.show'))
        ->toContain(route('terms.show'));
});
