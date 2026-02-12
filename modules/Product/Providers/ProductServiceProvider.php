<?php

namespace Modules\Product\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Factory::guessFactoryNamesUsing(
        //     fn(string $modelName) => 'Modules\\Product\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        // );
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'product');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
