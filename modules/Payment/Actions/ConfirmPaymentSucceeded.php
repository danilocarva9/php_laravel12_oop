<?php

namespace Modules\Payment\Actions;

use Illuminate\Support\Facades\DB;
use Modules\Payment\Events\PaymentCompletedEvent;
use Modules\Payment\Models\Payment;

class ConfirmPaymentSucceeded
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
            $payment->markAsPaid();
        });
    }
}
