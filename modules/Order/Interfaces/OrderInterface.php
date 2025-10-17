<?php

namespace Modules\Order\Interfaces;

interface OrderInterface
{
    public function create(int $customerId, array $items): array;

    public function get(int $orderId): ?array;
}
