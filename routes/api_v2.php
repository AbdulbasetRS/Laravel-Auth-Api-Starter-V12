<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V2\Admin\AuthController;

Route::prefix('v2')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::middleware('auth:api')->group(function () {
        Route::get('auth/me', [AuthController::class, 'me']);
    });
});