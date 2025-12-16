<?php

namespace Modules\Order\Interfaces;

use Modules\Order\Http\Resources\OrderResource;
use Modules\Order\Models\Order;

interface OrderInterface
{
    public function create(array $products): Order;

    public function get(int $id): OrderResource;
}
