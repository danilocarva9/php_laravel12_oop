<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Order\Actions\CreateOrderAction;
use Modules\Order\Actions\GetOrderAction;
use Modules\Order\Http\Requests\OrderCreateRequest;
use Modules\Order\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function show(int $id, GetOrderAction $action): OrderResource
    {
        return $action->handle($id);
    }

    public function create(OrderCreateRequest $request, CreateOrderAction $action): OrderResource
    {
        $order = $action->handle($request->array('products'));
        return new OrderResource($order);
    }
}
