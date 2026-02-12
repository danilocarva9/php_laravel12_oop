<?php

namespace Modules\Order\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
//use Modules\Order\Interfaces\OrderInterface; if neeed to bind interface to implementation

class OrderServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // if you need to bind interface to implementation
        //$this->app->singleton(OrderInterface::class, fn() => new OrderService());

        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'order');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
