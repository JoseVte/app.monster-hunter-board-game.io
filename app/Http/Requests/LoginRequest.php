<?php

namespace App\Http\Requests;

use App\Rules\Recaptcha;
use Laravel\Fortify\Http\Requests\LoginRequest as BaseLoginRequest;

class LoginRequest extends BaseLoginRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            // `required` is not decoration. Recaptcha is not an implicit rule,
            // so without it a request that leaves the field out skips the check
            // entirely and Google is never asked.
            'captcha_token' => ['required', new Recaptcha],
        ]);
    }
}
