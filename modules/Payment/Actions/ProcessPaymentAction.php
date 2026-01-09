<?php

namespace Modules\Payment\Actions;

use Illuminate\Support\Facades\DB;
use Modules\Order\Models\Order;
use Modules\Payment\Models\Payment;

class ProcessPaymentAction
{
    /**
     * Process payment for an order.
     *
     * @param array $payload
     * @param int $orderId
     * @return void
     */
    public function handle(array $payload, int $orderId): void
    {
        // should have all necessary payment details
        // should call external payment gateway here with the payment details
        // should handle success and failure responses
    }
}
