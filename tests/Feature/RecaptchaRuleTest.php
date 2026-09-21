<?php

use App\Rules\Recaptcha;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

function validateToken(mixed $input): Illuminate\Validation\Validator
{
    return Validator::make(
        $input === 'absent' ? [] : ['captcha_token' => $input],
        ['captcha_token' => ['required', new Recaptcha]]
    );
}

test('a token Google scores well passes', function (): void {
    fakeRecaptcha(['success' => true, 'score' => 0.9]);

    expect(validateToken('a-token')->fails())->toBeFalse();
});

test('a token Google scores badly is rejected', function (): void {
    fakeRecaptcha(['success' => true, 'score' => 0.1]);

    expect(validateToken('a-token')->fails())->toBeTrue();
});

test('a token Google does not recognise is rejected', function (): void {
    fakeRecaptcha(['success' => false, 'error-codes' => ['invalid-input-response']]);

    expect(validateToken('a-token')->fails())->toBeTrue();
});

// The rule used to be skipped entirely when the field was absent: it is not an
// implicit rule, and Laravel does not run those against an attribute that is not
// there. A POST that simply left `captcha_token` out sailed past without Google
// ever being asked, which is the one thing an anti-spam check must not allow.
test('a missing token is rejected rather than skipped', function (): void {
    fakeRecaptcha(['success' => true, 'score' => 0.9]);

    expect(validateToken('absent')->fails())->toBeTrue();

    Http::assertNothingSent();
});

// Google being unreachable must not take the login page down with it. The rule
// lets the request through and records why, which is a deliberate choice: an
// outage at Google locking every existing user out of their own account is
// worse than the spam that gets in during it, and the throttle still applies.
test('an unreachable Google lets the request through', function (): void {
    Http::swap(new Illuminate\Http\Client\Factory);
    Http::fake(fn () => throw new Illuminate\Http\Client\ConnectionException('could not connect'));

    expect(validateToken('a-token')->fails())->toBeFalse();
});

test('the message says what happened and mentions no telephone', function (): void {
    fakeRecaptcha(['success' => true, 'score' => 0.1]);

    $message = validateToken('a-token')->errors()->first('captcha_token');

    expect($message)->not->toContain('phone')
        ->and($message)->not->toContain('Something goes wrong');
});
