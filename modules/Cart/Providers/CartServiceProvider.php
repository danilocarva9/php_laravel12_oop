<?php

namespace Modules\Cart\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Cart\Interfaces\CartInterface;
use Modules\Cart\Service\CartService;
use Modules\Cart\Providers\RouteServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CartInterface::class, fn() => new CartService());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->app->register(RouteServiceProvider::class);  //$this->loadRoutesFrom(__DIR__ . '/../routes.php');
    }
}
