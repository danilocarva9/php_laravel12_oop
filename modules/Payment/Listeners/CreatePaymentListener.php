<?php

namespace Modules\Payment\Listeners;

use Modules\Order\Events\OrderCreatedEvent;
use Modules\Payment\Actions\CreatePaymentAction;

class CreatePaymentListener
{
    public function __construct(private CreatePaymentAction $action)
    {
        //
    }
    /**
     * Handle the event.
     */
    public function handle(OrderCreatedEvent $event): void
    {
        $this->action->handle($event->order);
    }
}
