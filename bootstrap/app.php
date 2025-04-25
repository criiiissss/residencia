<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.login' => \App\Http\Middleware\RedirectLogin::class,
            'auth.level1' => \App\Http\Middleware\Level1Login::class,
            'auth.level2' => \App\Http\Middleware\Level2Login::class,
            'auth.level3' => \App\Http\Middleware\Level3Login::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
