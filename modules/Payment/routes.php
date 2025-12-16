<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Controllers\PaymentController;

Route::group(['prefix' => 'payment', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', [PaymentController::class, 'create']);

    Route::get('{id}', [PaymentController::class, 'show']);

    Route::post('{id}/authorize', [PaymentController::class, 'authorize']);
    Route::post('{id}/capture', [PaymentController::class, 'capture']);
    Route::post('{id}/refund', [PaymentController::class, 'refund']);
});
