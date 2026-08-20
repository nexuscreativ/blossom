<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \App\Providers\AppServiceProvider::class,
        \App\Providers\PaymentServiceProvider::class,
        \App\Providers\Filament\AdminPanelProvider::class,
        \App\Providers\BlossomServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'webhooks/*',
        ]);

        $middleware->trustProxies(
            at: '*',
            headers: \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR |
                \Illuminate\Http\Request::HEADER_X_FORWARDED_HOST |
                \Illuminate\Http\Request::HEADER_X_FORWARDED_PORT |
                \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO |
                \Illuminate\Http\Request::HEADER_X_FORWARDED_AWS_ELB,
        );

        $middleware->alias([
            'premium' => \App\Http\Middleware\EnsurePremium::class,
            'installed' => \App\Http\Middleware\EnsureInstalled::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\EnsureInstalled::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
