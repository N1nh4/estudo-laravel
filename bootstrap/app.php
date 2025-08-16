<?php

use App\Http\Middleware\CheckToken;
use App\Http\Middleware\MiddlewareGlobal;
use App\Http\Middleware\MiddlewareGroup;
use App\Http\Middleware\UserAgent;
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
        // Middleware global
        $middleware->append(UserAgent::class);
    })
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware nomeado - só executa quando explicitamente usado na rota
        $middleware->alias([
            'user-agent' => UserAgent::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'middleware-group' => MiddlewareGroup::class, 
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        
        $middleware->alias([
            'check-token' => CheckToken::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(MiddlewareGlobal::class);
    })
    // Criando um grupo de middlewares nas versões antigas ele é criado no Kernel.php
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('myApp', [
            \App\Http\Middleware\CheckToken::class,
            \App\Http\Middleware\UserAgent::class,
            // outros middlewares
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
