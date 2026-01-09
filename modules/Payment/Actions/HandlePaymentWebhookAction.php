<?php

namespace Modules\Payment\Actions;

class HandlePaymentWebhookAction
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
            'success' => (new ConfirmPaymentSucceededAction())->handle($payload),
            'failure' => (new ConfirmPaymentFailedAction())->handle($payload),
            default => null,
        };
    }
}
