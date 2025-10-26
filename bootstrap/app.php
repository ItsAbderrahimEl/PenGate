<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\RateLimiterMiddleware;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware
            ->web(append: [
                HandleInertiaRequests::class,
                RateLimiterMiddleware::class
            ])
            ->redirectGuestsTo(fn(Request $request) => route('login.create'))
            ->redirectUsersTo(fn(Request $request) => route('posts.index'));
    })
    ->withExceptions(function (Exceptions $exceptions) {})
    ->create();
