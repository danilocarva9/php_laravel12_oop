<?php

namespace Modules\Customer\Service;

use Modules\Customer\Interfaces\CustomerInterface;

class CustomerService implements CustomerInterface
{
    public function create(array $data): array
    {
        // Simulate order creation logic
        return [
            'user_id' => $data['user_id'],
            'product_id' => $data['product_id'],
            'order_id' => rand(1000, 9999),
            'status' => 'created',
            'data' => $data,
        ];
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
