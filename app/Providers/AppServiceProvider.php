<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerTelescope();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureCommands();
        $this->configureModels();
        $this->configureUrl();
    }

    /**
     * Prevents destructive BD commands in production
     *
     * @return void
     */
    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->isProduction(),
        );
    }

    /**
     * Set defaul models configuration
     *
     * @return void
     */
    private function configureModels(): void
    {
        /**
         * Prevents lazy loading
         * Prevents silence discarding attributes
         * Prevents acessing missing attributes
         */
        Model::shouldBeStrict();
    }

    /**
     * Forces all generated URLs in production to use HTTPS
     *
     * @return void
     */
    private function configureUrl(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }

    private function registerTelescope(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }
}
