<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\ApiResponseTrait;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    use ApiResponseTrait;

    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            $status = 401;

            if ($e instanceof TokenInvalidException) {
                $message = __('auth.token_invalid');
            } elseif ($e instanceof TokenExpiredException) {
                $message = __('auth.token_expired');
            } elseif ($e instanceof JWTException) {
                $message = __('auth.token_not_found');
            } else {
                $message = __('auth.unauthorized');
            }

            return $this->error($message, $status);
        }

        return $next($request);
    }
}
