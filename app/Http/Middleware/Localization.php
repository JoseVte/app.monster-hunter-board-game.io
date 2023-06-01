<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Localization
{
    public function handle($request, Closure $next)
    {
        if (session()->has('locale')) {
            $locale = session()->get('locale');
        } else {
            $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            if (!in_array($locale, config('app.locales-available'), true)) {
                $locale = 'en';
            }
        }

        App::setLocale($locale);

        return $next($request);
    }
}
