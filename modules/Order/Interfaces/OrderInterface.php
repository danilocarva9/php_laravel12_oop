<?php

namespace Modules\Order\Interfaces;

use Modules\Order\Http\Resources\OrderResource;

interface OrderInterface
{
    public function create(array $order): OrderResource;

    public function get(int $id): OrderResource;
}
