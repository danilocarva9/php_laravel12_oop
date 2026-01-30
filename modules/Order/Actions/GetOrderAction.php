<?php

namespace Modules\Order\Actions;

use Illuminate\Support\Facades\DB;
use Modules\Order\DTO\CreateOrderDTO;
use Modules\Order\DTO\CreateOrderItemsDTO;
use Modules\Order\Exceptions\OrderNotFoundException;
use Modules\Order\Http\Resources\OrderResource;
use Modules\Order\Models\Order;
use Modules\Product\Models\Product;

class GetOrderAction
{

    /**
     * Get an order by ID.
     *
     * @param int $orderId
     * @return OrderResource
     * @throws OrderNotFoundException
     */
    public function handle(int $orderId): OrderResource
    {
        $order = Order::find($orderId);

        if (!$order) {
            throw new OrderNotFoundException();
        }

        return new OrderResource(
            $order->load('items.product', 'payment')
        );
    }
}
