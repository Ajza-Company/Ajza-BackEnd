<?php

use App\Http\Middleware\AuthCors;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        then: function () {
           Route::middleware(['api', 'auth.cors'])
                ->prefix('api/frontend')
                ->group(base_path('routes/frontend.php'));
            Route::middleware(['api', 'auth.cors'])
                ->prefix('api/supplier')
                ->group(base_path('routes/supplier.php'));
            Route::middleware(['api', 'auth.cors'])
                ->prefix('api/general')
                ->group(base_path('routes/general.php'));
            Route::middleware(['api', 'auth.cors'])
                ->prefix('api/admin')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Global middleware - applied to all route groups
        $middleware->use([
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);

        $middleware->alias([
            'auth.cors' => AuthCors::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
