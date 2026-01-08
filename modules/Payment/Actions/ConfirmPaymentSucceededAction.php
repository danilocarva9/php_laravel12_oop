<?php

namespace Modules\Payment\Actions;

use Illuminate\Support\Facades\DB;
use Modules\Order\Models\Order;
use Modules\Payment\Events\PaymentCompleted;
use Modules\Payment\Models\Payment;

class ConfirmPaymentSucceededAction
{
    /**
     * Confirm that the payment has succeeded.
     *
     * @param array $payload
     * @return void
     */
    public function handle(array $payload): void
    {
        DB::transaction(function () use ($payload) {
            $payment = Payment::where('transaction_id', $payload['transaction_id'])->firstOrFail();
            $payment->update(['status' => 'PAID']);

            $order = Order::findOrFail($payment->order_id);
            $order->update(['payment_status' => 'PAID']);

            event(new PaymentCompleted($order));
        });
    }
}
