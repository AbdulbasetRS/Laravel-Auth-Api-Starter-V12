<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Exception;

class UnauthenticatedCustomException extends Exception
{
    use ApiResponseTrait;

    public function __construct($message = null)
    {
        parent::__construct($message ?? __('auth.unauthenticated'));
    }

    public function render($request)
    {
        if ($request->expectsJson()) {
            return $this->error($this->getMessage(), 401);
        }

        return response()->view('errors.unauthenticated', [
            'message' => $this->getMessage(),
        ], 401);
    }
}
