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
        // Trust reverse proxy (master nginx) so Laravel generates https:// URLs
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
            'teacher' => \App\Http\Middleware\IsTeacher::class,
            'student' => \App\Http\Middleware\IsStudent::class,
            'class.selected' => \App\Http\Middleware\CheckClassSelection::class,
            'payment.verified' => \App\Http\Middleware\CheckPaymentVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
