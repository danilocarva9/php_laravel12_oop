<?php

namespace Modules\User\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'user');
    }
}
