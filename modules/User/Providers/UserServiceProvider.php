<?php

namespace Modules\User\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Factory::guessFactoryNamesUsing(
        //     fn(string $modelName) => 'Modules\\User\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        // );
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'user');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->app->register(EventServiceProvider::class);
    }
}
