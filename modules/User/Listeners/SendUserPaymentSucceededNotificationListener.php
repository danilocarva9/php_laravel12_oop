<?php

namespace Modules\User\Listeners;

use Modules\Payment\Events\PaymentCompletedEvent;

class SendUserPaymentSucceededNotificationListener
{
    /**
     * Handle the event.
     */
    public function handle(PaymentCompletedEvent $event): void
    {
        // Logic to send notification to the user about payment success
        // listing order details from $event->order
    }
}
