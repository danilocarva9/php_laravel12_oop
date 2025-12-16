<?php

namespace Modules\Order\Interfaces;

use Modules\Order\Http\Resources\OrderResource;

interface OrderInterface
{
    public function create(string $idempotencyKey, array $requests): OrderResource;

    public function get(int $id): OrderResource;
}
