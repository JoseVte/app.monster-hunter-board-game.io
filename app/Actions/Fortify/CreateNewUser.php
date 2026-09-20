<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\Recaptcha;
use Laravel\Jetstream\Jetstream;
use App\Actions\PrepareNewAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function __construct(private PrepareNewAccount $prepareNewAccount) {}

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'captcha_token' => [new Recaptcha(0.5)],
        ])->validate();

        return DB::transaction(fn () => tap(User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]), fn (User $user) => ($this->prepareNewAccount)($user)));
    }
}
