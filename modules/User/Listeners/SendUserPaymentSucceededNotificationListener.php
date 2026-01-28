<?php

namespace Modules\User\Listeners;

use Modules\Order\Models\Order;
use Modules\Payment\Enums\PaymentStatusEnum;
use Modules\Payment\Events\PaymentCompletedEvent;

class SendUserPaymentSucceededNotificationListener
{
    /**
     * Handle the event.
     */
    public function handle(PaymentCompletedEvent $event): void
    {
        // Accessing order details
        // Logic to send notification to the user about payment success
        // listing order details from $event->order
    }
}
