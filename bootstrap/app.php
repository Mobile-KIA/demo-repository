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
        'orang_tua' => \App\Http\Middleware\OrangTuaMiddleware::class,
        'tenaga_medis' => \App\Http\Middleware\TenagaMedisMiddleware::class,
    ]);
})

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
