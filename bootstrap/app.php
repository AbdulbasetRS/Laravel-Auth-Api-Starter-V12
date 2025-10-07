<?php

use App\Exceptions\MethodNotAllowedCustomException;
use App\Exceptions\ModelNotFoundCustomException;
use App\Exceptions\RouteNotFoundCustomException;
use App\Exceptions\UnauthenticatedCustomException;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\SetLocaleFromRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: [
            __DIR__.'/../routes/api_v1.php',
            __DIR__.'/../routes/api_v2.php',
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->prepend([
            SetLocaleFromRequest::class,
        ]);

        $middleware->alias([
            'jwt' => JwtMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (MethodNotAllowedHttpException $e) {
            throw new MethodNotAllowedCustomException;
        });
        $exceptions->renderable(function (ModelNotFoundException $e) {
            throw new ModelNotFoundCustomException;
        });
        $exceptions->renderable(function (NotFoundHttpException $e) {
            throw new RouteNotFoundCustomException;
        });
        $exceptions->renderable(function (AuthenticationException $e, $request) {
            throw new UnauthenticatedCustomException;
        });

    })->create();
