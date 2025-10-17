<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Order\Http\Requests\CreateRequest;
use Modules\Order\Interfaces\OrderInterface;

class OrderController extends Controller
{
    public function __construct(private OrderInterface $order) {}

    public function create(CreateRequest $request): array
    {
        $data = $request->all();
        return $this->order->create($data);
    }

    public function get(int $orderId): ?array
    {
        return $this->order->get($orderId);
    }
}
