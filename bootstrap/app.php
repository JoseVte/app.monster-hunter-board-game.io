<?php

use App\Http\Middleware\Localization;
use Illuminate\Foundation\Application;
use App\Providers\RouteServiceProvider;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            Localization::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->api(prepend: [
            'throttle:api',
        ]);

        $middleware->redirectUsersTo(RouteServiceProvider::HOME);

        $middleware->trustProxies(headers: Illuminate\Http\Request::HEADER_X_FORWARDED_FOR
            | Illuminate\Http\Request::HEADER_X_FORWARDED_HOST
            | Illuminate\Http\Request::HEADER_X_FORWARDED_PORT
            | Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO
            | Illuminate\Http\Request::HEADER_X_FORWARDED_AWS_ELB);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->reportable(function (Throwable $exception): void {
            if (app()->bound('sentry')) {
                app('sentry')->captureException($exception);
            }
        });

        // A 419 means the session died while the form was open. Sending the
        // visitor back with a notice lets them retry, where the default error
        // page is a dead end inside an Inertia dialog.
        $exceptions->respond(function ($response) {
            if ($response->getStatusCode() === 419) {
                return back()->with([
                    'status' => __('The page expired, please try again.'),
                ]);
            }

            return $response;
        });
    })->create();
