<?php

namespace Modules\Payment\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Order\Events\OrderCreatedEvent;
use Modules\Payment\Listeners\CreatePaymentListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            OrderCreatedEvent::class,
            CreatePaymentListener::class
        );
    }
}
