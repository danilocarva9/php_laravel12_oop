<?php

use Illuminate\Support\Facades\Route;
use Modules\Shipment\Controllers\ShipmentController;

Route::group(['prefix' => 'shipment', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', [ShipmentController::class, 'updateStatus']);
});
