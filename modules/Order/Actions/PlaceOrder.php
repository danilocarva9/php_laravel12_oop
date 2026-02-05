<?php

namespace Modules\Order\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Customer\Models\Customer;
use Modules\Order\Domain\Items;
use Modules\Order\Jobs\CreateOrderJob;
use Modules\Order\Models\Order;
use Modules\Payment\Actions\CreatePayment;

class PlaceOrder
{
    public function __construct(private CreatePayment $createPayment) {}

    /**
     * Handle the action to create a new order.
     *
     * @param array $request
     * @return Order
     */
    public function handle(Customer $customer, array $products): Order
    {
        $items = Items::fromArray($products);

        $order = DB::transaction(function () use ($customer, $items) {
            $order = Order::place($customer, $items);
            $this->createPayment->handle($order);
            return $order;
        });

        // Dispatch job for further processing (e.g., sending confirmation email)
        // CreateOrderJob::dispatch($order);
        Log::info("Order {$order->id} created for customer {$customer->id}.");

        return $order;
    }
}
