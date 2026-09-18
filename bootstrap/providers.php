<?php

use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use App\Providers\RouteServiceProvider;
use App\Providers\FortifyServiceProvider;
use App\Providers\HorizonServiceProvider;
use App\Providers\JetstreamServiceProvider;
use App\Providers\TypeScriptTransformerServiceProvider;

return array_values(array_filter([
    AppServiceProvider::class,
    AuthServiceProvider::class,
    HorizonServiceProvider::class,
    RouteServiceProvider::class,
    FortifyServiceProvider::class,
    JetstreamServiceProvider::class,
    class_exists(Spatie\LaravelTypeScriptTransformer\TypeScriptTransformerApplicationServiceProvider::class)
        ? TypeScriptTransformerServiceProvider::class
        : null,
]));
