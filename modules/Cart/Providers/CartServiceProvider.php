<?php

namespace Modules\Cart\Providers;

use Illuminate\Support\Facades\Route;
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
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'cart');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
