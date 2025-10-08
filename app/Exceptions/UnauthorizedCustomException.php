<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponseTrait;

class UnauthorizedCustomException extends Exception
{
    use ApiResponseTrait;

    public function render($request)
    {
        return $this->error(
            message: 'ليس لديك صلاحية لتنفيذ هذا الإجراء.',
            code: 403
        );
    }
}
