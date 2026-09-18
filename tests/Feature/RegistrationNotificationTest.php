<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

test('the registered event has exactly one listener', function (): void {
    $listeners = Event::getRawListeners()[Registered::class] ?? [];

    expect($listeners)->toEqual([SendEmailVerificationNotification::class]);
});
