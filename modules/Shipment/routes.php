<?php

use Illuminate\Support\Facades\Route;

Route::get('/shipment', function () {
    return response()->json(['welcome' => 'Shipment Module']);
});
