<?php

namespace Modules\Order\Providers;

use Illuminate\Support\ServiceProvider;
//use Modules\Order\Interfaces\OrderInterface; if neeed to bind interface to implementation
use Modules\Order\Service\OrderService;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // if you need to bind interface to implementation
        //$this->app->singleton(OrderInterface::class, fn() => new OrderService());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->app->register(RouteServiceProvider::class);  //$this->loadRoutesFrom(__DIR__ . '/../routes.php');
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'order');
    }
}
