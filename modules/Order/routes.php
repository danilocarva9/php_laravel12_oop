<?php

use Illuminate\Support\Facades\Route;

Route::get('/order', function () {
    return response()->json(['welcome' => 'Order Module']);
});
