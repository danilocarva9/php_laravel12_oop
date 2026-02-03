<?php

namespace Modules\Order\Actions;

use Illuminate\Support\Facades\Log;
use Modules\Order\Domain\Items;
use Modules\Order\Jobs\CreateOrderJob;
use Modules\Order\Models\Order;

class CreateOrderAction
{

    /**
     * Handle the action to create a new order.
     *
     * @param array $request
     * @return Order
     */
    public function handle(array $products): Order
    {
        $customer = auth('sanctum')->user()->customer;
        $items = Items::fromArray($products);

        $order = Order::place($customer, $items);

        // Dispatch job for further processing (e.g., sending confirmation email)
        CreateOrderJob::dispatch($order);

        Log::info("Order {$order->id} created for customer {$customer->id}.");

        return $order;
    }
}
