<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function success($data = [], $message = null, $code = 200)
    {
        return response()->json([
            'status'  => true,
            'message' => $message ?? __('messages.success'),
            'data'    => $data
        ], $code);
    }

    protected function error($message = null, $code = 400, $errors = [])
    {
        return response()->json([
            'status'  => false,
            'message' => $message ?? __('messages.error'),
            'errors'  => $errors
        ], $code);
    }
}
