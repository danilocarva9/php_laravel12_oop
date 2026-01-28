<?php

namespace Modules\Payment\Actions;

use Illuminate\Support\Facades\DB;
use Modules\Order\Models\Order;
use Modules\Payment\Enums\PaymentStatusEnum;
use Modules\Payment\Models\Payment;

class CreatePaymentAction
{
    /**
     * Create a new pending payment record.
     *
     * @param Order $order
     * @return Payment
     */
    public function handle(Order $order)
    {
        return DB::transaction(function () use ($order) {
            Payment::create([
                'transaction_id' => uniqid('pay_'),
                'order_id' => $order->id,
                'payment_method' => 'PENDING',
                'amount' => $order->total_amount,
                'status' => PaymentStatusEnum::class::UNPAID,
            ]);
        });
    }
}
