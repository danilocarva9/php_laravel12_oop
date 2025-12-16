<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\Http\Controllers\CartController;

Route::group(['prefix' => 'cart', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [CartController::class, 'show']);

    Route::post('items', [CartController::class, 'add']);
    Route::put('items/{id}', [CartController::class, 'update']);
    Route::delete('items/{id}', [CartController::class, 'remove']);
    Route::post('clear', [CartController::class, 'clear']);

    Route::post('checkout', [CartController::class, 'checkout']);
});
