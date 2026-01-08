<?php

namespace Modules\Payment\Actions;

use Illuminate\Support\Facades\DB;
use Modules\Order\Models\Order;
use Modules\Payment\Models\Payment;

class HandlePaymentWebhookAction
{
    /**
     * Process payment for an order.
     *
     * @param array $payload
     * @param int $orderId
     * @return void
     */
    public function handle(array $payload): void
    {
        match ($payload['status']) {
            'success' => new ConfirmPaymentSucceededAction()->handle($payload),
            'failure' => new ConfirmPaymentFailedAction()->handle($payload),
            default => null,
        };
    }
}
