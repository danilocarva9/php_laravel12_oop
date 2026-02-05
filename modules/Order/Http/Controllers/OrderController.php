<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Order\Actions\GetOrder;
use Modules\Order\Actions\PlaceOrder;
use Modules\Order\Http\Requests\OrderCreateRequest;
use Modules\Order\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function show(int $id, GetOrder $getOrder): OrderResource
    {
        $order = $getOrder->handle($id);
        return new OrderResource($order);
    }

    public function create(OrderCreateRequest $request, PlaceOrder $placeOrder): OrderResource
    {
        $order = $placeOrder->handle(
            auth('sanctum')->user()->customer,
            $request->array('products')
        );
        return new OrderResource($order);
    }
}
