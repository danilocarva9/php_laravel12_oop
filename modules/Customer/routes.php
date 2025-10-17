<?php

use Illuminate\Support\Facades\Route;

Route::prefix('customer')->group(function () {
    Route::get('/{customerId}', [\Modules\Customer\Http\Controllers\CustomerController::class, 'get']);
});
