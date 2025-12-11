<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [\Modules\Auth\Http\Controllers\AuthController::class, 'register']);
    Route::post('/login', [\Modules\Auth\Http\Controllers\AuthController::class, 'login']);
});
