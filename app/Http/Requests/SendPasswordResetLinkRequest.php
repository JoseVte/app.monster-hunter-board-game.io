<?php

namespace App\Http\Requests;

use App\Rules\Recaptcha;
use Laravel\Fortify\Http\Requests\SendPasswordResetLinkRequest as BaseSendPasswordResetLinkRequest;

/**
 * Fortify's own request, with a captcha added.
 *
 * This form is the softest target the app has: anyone can post to it, it sends
 * an email for every request, and Fortify applies no rate limiter to it, unlike
 * login and the two-factor challenge.
 */
class SendPasswordResetLinkRequest extends BaseSendPasswordResetLinkRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            // Required for the same reason it is on the login form: Recaptcha is
            // not an implicit rule, so without this a request that leaves the
            // field out skips the check entirely.
            'captcha_token' => ['required', new Recaptcha],
        ]);
    }
}
