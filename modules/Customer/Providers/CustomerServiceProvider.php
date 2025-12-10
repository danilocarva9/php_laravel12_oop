<?php

namespace Modules\Customer\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Customer\Interfaces\CustomerInterface;
use Modules\Customer\Providers\RouteServiceProvider;
use Modules\Customer\Service\CustomerService;

class CustomerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CustomerInterface::class, fn() => new CustomerService());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->app->register(RouteServiceProvider::class);
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'customer');
    }
}
