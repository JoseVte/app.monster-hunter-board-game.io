<?php

namespace App\Http\Requests;

use App\Rules\Recaptcha;
use Laravel\Fortify\Http\Requests\LoginRequest as BaseLoginRequest;

class LoginRequest extends BaseLoginRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'captcha_token' => [new Recaptcha(0.5)],
        ]);
    }
}
