<?php

namespace Modules\Payment\Actions;

class HandlePaymentWebhook
{
    /**
     * Process payment for an order.
     *
     * @param array $payload
     * @return void
     */
    public function handle(array $payload): void
    {
        match ($payload['status']) {
            'success' => (new ConfirmPaymentSucceeded())->handle($payload),
            'failure' => (new ConfirmPaymentFailedAction())->handle($payload),
            default => null,
        };
    }
}
