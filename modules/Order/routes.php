<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\OrderController;

Route::group(['prefix' => 'order', 'middleware' => 'auth:sanctum'], function () {
    Route::get('{id}', [OrderController::class, 'show']);
    Route::post('/', [OrderController::class, 'create']);

    Route::post('{id}/confirm', [OrderController::class, 'confirm']);
    Route::post('{id}/cancel', [OrderController::class, 'cancel']);
});
