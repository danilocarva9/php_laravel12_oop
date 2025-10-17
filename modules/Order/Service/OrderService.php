<?php

namespace Modules\Order\Service;

use Modules\Order\Interfaces\OrderInterface;
use Modules\Order\Models\Order;

class OrderService implements OrderInterface
{
    public function create(int $customerId, array $items): array
    {
        // Simulate order creation logic
        $order = Order::create([
            'customer_id' => $customerId,
            'status' => 'PENDING',
            'total_amount' => 0
        ]);

        foreach ($items as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return $order;
    }

    public function get(int $orderId): ?array
    {
        // Simulate fetching an order
        return [
            'order_id' => $orderId,
            'status' => 'created',
            'items' => [],
        ];
    }
}
