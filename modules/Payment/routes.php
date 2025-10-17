<?php

use Illuminate\Support\Facades\Route;

Route::get('/payment', function () {
    return response()->json(['welcome' => 'Payment Module']);
});
