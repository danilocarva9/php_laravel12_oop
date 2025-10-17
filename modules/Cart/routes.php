<?php

use Illuminate\Support\Facades\Route;

Route::prefix('cart')->group(function () {
    Route::post('/create', [\Modules\Cart\Http\Controllers\CartController::class, 'create']);
});
