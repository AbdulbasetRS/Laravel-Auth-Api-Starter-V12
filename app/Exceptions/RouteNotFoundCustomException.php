<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Exception;

class RouteNotFoundCustomException extends Exception
{
    use ApiResponseTrait;

    public function __construct($message = null)
    {
        parent::__construct($message);
    }

    public function render($request)
    {
        $message = $this->getMessage() ?: __('messages.route_not_found');

        if ($request->expectsJson()) {
            return $this->error($message, 404);
        }

        return response()->view('errors.route_not_found', [
            'message' => $message,
        ], 404);
    }
}
