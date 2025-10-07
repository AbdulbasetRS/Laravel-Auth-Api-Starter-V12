<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponseTrait;

class ModelNotFoundCustomException extends Exception
{
    use ApiResponseTrait;

    public function __construct($message = null)
    {
        parent::__construct($message ?? 'العنصر المطلوب غير موجود.');
    }

    public function render($request)
    {
        if ($request->expectsJson()) {
            return $this->error($this->getMessage().'ModelNotFoundCustomException', 404);
        }

        return response()->view('errors.not_found', [
            'message' => $this->getMessage(),
        ], 404);
    }
}
