<?php

namespace Modules\User\Listeners;

use Modules\Payment\Events\PaymentCompleted;

class SendUserPaymentSucceededNotification
{
    /**
     * Handle the event.
     */
    public function handle(PaymentCompleted $event): void
    {
        // Logic to send notification to the user about payment success
        // listing order details from $event->order
    }
}
