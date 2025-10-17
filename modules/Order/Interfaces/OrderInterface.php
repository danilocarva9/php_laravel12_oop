<?php

namespace Modules\Order\Interfaces;

interface OrderInterface
{
    public function create(array $data): array;

    public function get(int $orderId): ?array;
}
