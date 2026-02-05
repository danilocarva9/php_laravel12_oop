<?php

namespace Modules\Order\Actions;

use Modules\Order\Exceptions\OrderNotFoundException;
use Modules\Order\Models\Order;

class GetOrder
{

    /**
     * Get an order by ID.
     *
     * @param int $orderId
     * @return Order
     * @throws OrderNotFoundException
     */
    public function handle(int $orderId): Order
    {
        $order = Order::find($orderId);

        if (!$order) {
            throw new OrderNotFoundException();
        }

        return  $order->load('items.product', 'payment');
    }
}
