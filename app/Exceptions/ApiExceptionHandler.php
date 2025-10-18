<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ApiExceptionHandler
{
    public static function handle(Throwable $e)
    {
        // 404 - Route Not Found
        if ($e instanceof NotFoundHttpException) {
            if (request()->is('api/*') && ($e->getPrevious() instanceof ModelNotFoundException)) {
                // $message = match ($e->getPrevious()->getModel()) {
                //     // 'App\Models\User' => throw new UserNotFoundCustomException,
                //     // ... Add Other models here
                // };
                throw new ModelNotFoundCustomException;
            }
            throw new RouteNotFoundCustomException;
        }

        // 405 - Method Not Allowed
        if ($e instanceof MethodNotAllowedHttpException) {
            throw new MethodNotAllowedCustomException;
        }

        // 401 - Unauthenticated
        if ($e instanceof AuthenticationException) {
            throw new UnauthenticatedCustomException;
        }

        // 403 - Unauthorized
        if ($e instanceof AccessDeniedHttpException) {
            throw new UnauthorizedCustomException;
        }

        // 500 - Unexpected Error
        throw new InternalServerErrorCustomException($e->getMessage());
    }
}
