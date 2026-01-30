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

            $totalAmount = $this->calculateTotalAmount($order->items->toArray());

            Payment::create([
                'transaction_id' => uniqid('pay_'),
                'order_id' => $order->id,
                'payment_method' => 'PENDING',
                'amount' => $totalAmount,
                'status' => PaymentStatusEnum::class::UNPAID,
            ]);
        });
    }


    /**
     * Calculate the total amount for the order items.
     *
     * @param array $items
     * @return int
     */
    private function calculateTotalAmount(array $items): int
    {
        return array_reduce($items, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }
}
