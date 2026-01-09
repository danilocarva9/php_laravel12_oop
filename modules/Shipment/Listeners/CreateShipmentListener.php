<?php

namespace Modules\Shipment\Listeners;

use Modules\Payment\Events\PaymentCompleted;
use Modules\Shipment\Actions\CreateShipmentAction;

class CreateShipmentListener
{
    public function __construct(private CreateShipmentAction $action)
    {
        //
    }
    /**
     * Handle the event.
     */
    public function handle(PaymentCompleted $event): void
    {
        $this->action->handle($event->order);
    }
}
