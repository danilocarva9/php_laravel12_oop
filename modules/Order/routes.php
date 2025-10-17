<?php

use Illuminate\Support\Facades\Route;

Route::prefix('order')->group(function () {
    Route::post('/create', [\Modules\Order\Http\Controllers\OrderController::class, 'create']);
    Route::get('/{orderId}', [\Modules\Order\Http\Controllers\OrderController::class, 'get']);
});
