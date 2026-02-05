<?php

namespace Modules\Payment\Actions;

use Modules\Order\Models\Order;
use Modules\Payment\Enums\PaymentStatusEnum;

class CreatePayment
{
    /**
     * Create a new pending payment record.
     *
     * @param Order $order
     * @return void
     */
    public function handle(Order $order): void
    {
        $order->payment()->create([
            'transaction_id' => uniqid('pay_'),
            'payment_method' => 'PENDING',
            'amount' => $order->calculateTotal(),
            'status' => PaymentStatusEnum::class::UNPAID,
        ]);
    }
}
