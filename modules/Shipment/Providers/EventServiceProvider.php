<?php

namespace Modules\Shipment\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            \Modules\Payment\Events\PaymentCompleted::class,
            \Modules\Shipment\Listeners\CreateShipmentListener::class
        );
    }
}
