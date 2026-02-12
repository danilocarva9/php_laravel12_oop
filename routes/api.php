<?php

use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['welcome' => 'Hello World']);
});

Route::middleware('api')
    ->group(function () {
        collect(glob(base_path('modules/*/routes.php')))
            ->sort()
            ->each(fn($routeFile) => require $routeFile);
    });
