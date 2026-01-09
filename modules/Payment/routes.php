<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Controllers\PaymentController;

Route::group(['prefix' => 'payment', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/process', [PaymentController::class, 'process']);
    Route::post('/callback', [PaymentController::class, 'callback']);
});
