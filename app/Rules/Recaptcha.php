<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Checks a reCAPTCHA v3 token against Google, which answers with a score from
 * 0.0 to 1.0 rather than a pass or a fail.
 *
 * **Always pair it with `required`.** This rule is not implicit, so Laravel does
 * not run it against an attribute that is absent, and a request that simply left
 * the field out used to sail past without Google ever being asked.
 */
readonly class Recaptcha implements ValidationRule
{
    public function __construct(private ?float $score = null) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $threshold = $this->score ?? config('services.google-recaptcha.score');

        try {
            $response = Http::asForm()->post(config('services.google-recaptcha.url'), [
                'secret' => config('services.google-recaptcha.secret-key'),
                'response' => $value,
            ]);
        } catch (ConnectionException $e) {
            // Google being unreachable must not take the sign-in page down with
            // it. Letting the request through is deliberate: an outage there
            // locking every existing user out of their own account is worse than
            // the spam that gets in during it, and the rate limiter still applies.
            Log::warning('Could not reach reCAPTCHA, letting the request through.', [
                'reason' => $e->getMessage(),
            ]);

            return;
        }

        // A 5xx leaves `success` null, which is not a verdict either. Same call.
        if ($response->failed()) {
            Log::warning('reCAPTCHA answered with an error, letting the request through.', [
                'status' => $response->status(),
            ]);

            return;
        }

        if (! $response['success'] || $response['score'] <= $threshold) {
            $fail(__('We could not confirm you are not a robot. Please reload the page and try again.'));
        }
    }
}
