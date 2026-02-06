<?php

namespace Modules\Payment\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Request;
use Modules\Payment\Actions\HandlePaymentWebhook;
use Modules\Payment\Actions\ProcessPaymentAction;
use Modules\Payment\Http\Requests\CallbackRequest;

class PaymentController extends Controller
{
    public function process(Request $request, ProcessPaymentAction $action, int $orderId)
    {
        $action->handle($request->validated(), $orderId);
    }

    public function callback(CallbackRequest $request, HandlePaymentWebhook $action)
    {
        $action->handle($request->validated());
    }
}
