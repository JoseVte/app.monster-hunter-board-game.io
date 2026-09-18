<?php

namespace App\Http\Controllers\Auth;

use Throwable;
use App\Models\Team;
use App\Models\User;
use App\Models\Provider;
use Illuminate\Support\Str;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAuthController extends Controller
{
    public function redirect(string $provider): RedirectResponse
    {
        try {
            return Socialite::driver($provider)->redirect();
        } catch (Throwable $exception) {
            report($exception);

            return redirect()->route('login')->with('error', __('Invalid credentials provided.'));
        }
    }

    public function redirectFromProfile(string $provider): RedirectResponse
    {
        session()->put('url.intended', route('profile.show'));

        return $this->redirect($provider);
    }

    public function callback(string $provider): RedirectResponse
    {
        $intended = session('url.intended');

        try {
            $providerUser = Socialite::driver($provider)->user();
        } catch (Throwable $exception) {
            report($exception);

            return redirect($intended ?: route('login'))->with('error', __('Invalid credentials provided.'));
        }

        $linking = auth()->check();

        if ($linking) {
            return $this->link(auth()->user(), $provider, $providerUser);
        }

        $user = User::where('email', $providerUser->getEmail())->first();

        if (! $user && ! Features::enabled(Features::registration())) {
            return redirect()->route('login')->with('error', __('We could not find your account. Please register to create an account.'));
        }

        $user = DB::transaction(fn (): User => $this->store($user, $provider, $providerUser));

        auth()->login($user, true);
        session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function unlink(string $provider): RedirectResponse
    {
        auth()->user()->providers()->where('provider', $provider)->delete();

        return back(303)->with('message', __('Social account unlinked successfully.'));
    }

    private function link(User $user, string $provider, ProviderUser $providerUser): RedirectResponse
    {
        $owner = Provider::where('provider', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($owner && $owner->user_id !== $user->id) {
            return redirect()->route('profile.show')
                ->with('error', __('It looks like this :provider account is used by another user. Please log in.', ['provider' => Str::title($provider)]));
        }

        $this->rememberProvider($user, $provider, $providerUser);

        return redirect()->route('profile.show')->with('message', __('Social account linked successfully.'));
    }

    private function store(?User $user, string $provider, ProviderUser $providerUser): User
    {
        if (! $user) {
            $user = User::create([
                'name' => $providerUser->getName() ?? $providerUser->getNickname(),
                'email' => $providerUser->getEmail(),
                'password' => Hash::make(Str::password()),
            ]);

            $user->markEmailAsVerified();
            $this->createPersonalTeam($user);

            event(new Registered($user));
        }

        $this->rememberProvider($user, $provider, $providerUser);

        return $user;
    }

    private function rememberProvider(User $user, string $provider, ProviderUser $providerUser): void
    {
        $user->providers()->updateOrCreate([
            'provider' => $provider,
            'provider_id' => $providerUser->getId(),
        ], [
            'name' => $providerUser->getName(),
            'nickname' => $providerUser->getNickname(),
            'email' => $providerUser->getEmail(),
            'avatar_path' => $providerUser->getAvatar(),
            'token' => $providerUser->token ?? '',
            'refresh_token' => $providerUser->refreshToken ?? null,
            'expires_at' => isset($providerUser->expiresIn) ? now()->addSeconds($providerUser->expiresIn) : null,
        ]);
    }

    private function createPersonalTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));

        $user->switchTeam($user->ownedTeams()->first());
    }
}
