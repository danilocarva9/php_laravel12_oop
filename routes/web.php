<?php

use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return ['welcome' => 'Hello World'];
});
