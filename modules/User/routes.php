<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'products'], function () {
    // Route::get('/', [\Modules\Product\Http\Controllers\ProductController::class, 'index']);
    // Route::get('/{id}', [\Modules\Product\Http\Controllers\ProductController::class, 'show']);
});
