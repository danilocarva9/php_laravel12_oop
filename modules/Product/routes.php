<?php

use Illuminate\Support\Facades\Route;

Route::get('/product', function () {
    return response()->json(['welcome' => 'Product Module']);
});
