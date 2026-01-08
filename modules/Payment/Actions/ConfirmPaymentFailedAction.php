<?php

namespace Modules\Payment\Actions;

use Illuminate\Support\Facades\DB;
use Modules\Order\Models\Order;
use Modules\Payment\Models\Payment;

class ConfirmPaymentFailedAction
{
    /**
     * Confirm that the payment has failed.
     *
     * @param array $payload
     * @return void
     */
    public function handle(array $payload): void
    {
        // should have all necessary payment details
        // should call external payment gateway here with the payment details
        // should handle success and failure responses
    }
}
