<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class InternalServerErrorCustomException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => __('messages.unexpected_error'),
            'error' => config('app.debug') ? $this->getMessage() : null,
        ], 500);
    }
}
