<?php

use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use App\Providers\RouteServiceProvider;
use App\Providers\FortifyServiceProvider;
use App\Providers\HorizonServiceProvider;
use App\Providers\JetstreamServiceProvider;

return [
    AppServiceProvider::class,
    AuthServiceProvider::class,
    HorizonServiceProvider::class,
    RouteServiceProvider::class,
    FortifyServiceProvider::class,
    JetstreamServiceProvider::class,
];
