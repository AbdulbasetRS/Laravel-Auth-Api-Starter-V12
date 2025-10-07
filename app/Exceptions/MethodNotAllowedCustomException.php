<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponseTrait;

class MethodNotAllowedCustomException extends Exception
{
    use ApiResponseTrait;

    public function __construct($message = null)
    {
        parent::__construct($message ?? 'الطريقة المستخدمة غير مسموح بها لهذا المسار.');
    }

    public function render($request)
    {
        // لو الطلب API أو فيه Accept: application/json
        if ($request->expectsJson()) {
            return $this->error($this->getMessage(), 405);
        }

        // لو الطلب Web عادي
        return response()->view('errors.method_not_allowed', [
            'message' => $this->getMessage(),
        ], 405);
    }
}
