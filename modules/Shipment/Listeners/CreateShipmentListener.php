<?php

namespace Modules\Shipment\Listeners;

use Modules\Payment\Events\PaymentCompletedEvent;
use Modules\Shipment\Actions\CreateShipment;

class CreateShipmentListener
{
    public function __construct(private CreateShipment $action)
    {
        //
    }
    /**
     * Handle the event.
     */
    public function handle(PaymentCompletedEvent $event): void
    {
        $this->action->handle($event->order);
    }
}
