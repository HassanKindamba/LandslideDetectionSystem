<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // *** Tumeongeza hii ili routes/api.php ifanye kazi ***
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // *** kuondoa CSRF requirement kwa ESP32 ***
        $middleware->validateCsrfTokens(except: [
            'api/sensor-data',
            'sensor-data',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();