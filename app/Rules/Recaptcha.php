<?php

namespace App\Rules;

use Http;
use Illuminate\Contracts\Validation\Rule;

readonly class Recaptcha implements Rule
{
    public function __construct(private float $score = 0.5)
    {
    }

    public function passes($attribute, $value): bool
    {
        $endpoint = config('services.google-recaptcha.url');

        $response = Http::asForm()->post($endpoint, [
            'secret' => config('services.google-recaptcha.secret-key'),
            'response' => $value,
        ]);

        return $response['success'] && $response['score'] > $this->score;
    }

    public function message(): string
    {
        return __('Something goes wrong. Please contact us directly through the phone or email.');
    }
}
