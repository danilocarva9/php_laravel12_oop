<?php

namespace Modules\Shipment\Providers;

use Illuminate\Support\ServiceProvider;

class ShipmentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->app->register(RouteServiceProvider::class);
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'shipment');
    }
}
