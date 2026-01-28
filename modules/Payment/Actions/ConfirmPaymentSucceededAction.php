<?php

namespace Modules\Payment\Actions;

use Illuminate\Support\Facades\DB;
use Modules\Order\Models\Order;
use Modules\Payment\Events\PaymentCompleted;
use Modules\Payment\Events\PaymentCompletedEvent;
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
        $order = DB::transaction(function () use ($payload) {
            $payment = Payment::where('transaction_id', $payload['transaction_id'])->firstOrFail();
            $payment->markAsPaid();

            return $payment->order;
        });

        event(new PaymentCompletedEvent($order));
    }
}
