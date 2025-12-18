<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Order\Http\Requests\OrderCreateRequest;
use Modules\Order\Http\Resources\OrderResource;
use Modules\Order\Interfaces\OrderInterface;
use Modules\Order\Models\Order;

class OrderController extends Controller
{
    public function __construct(private OrderInterface $order) {}

    public function show(int $id): OrderResource
    {
        return $this->order->get($id);
    }

    public function create(OrderCreateRequest $request): OrderResource
    {
        return $this->order->create($request->validated());
    }
}
