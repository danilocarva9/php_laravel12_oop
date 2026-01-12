<?php

namespace Modules\Shipment\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Payment\Events\PaymentCompletedEvent;
use Modules\Shipment\Listeners\CreateShipmentListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            PaymentCompletedEvent::class,
            CreateShipmentListener::class
        );
    }
}
