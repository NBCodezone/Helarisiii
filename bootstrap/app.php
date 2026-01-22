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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'developer' => \App\Http\Middleware\DeveloperMiddleware::class,
            'order_manager' => \App\Http\Middleware\OrderManagerMiddleware::class,
            'stock_manager' => \App\Http\Middleware\StockManagerMiddleware::class,
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
        $middleware->appendToGroup('web', \App\Http\Middleware\EnsureSiteIsLive::class);
    })
    ->withSchedule(function ($schedule) {
        $schedule->command('featured:rotate')->hourly();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
