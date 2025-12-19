<?php

namespace Modules\Order\Actions;

use Illuminate\Support\Facades\DB;
use Modules\Order\DTO\CreateOrderDTO;
use Modules\Order\DTO\CreateOrderItemsDTO;
use Modules\Order\Http\Resources\OrderResource;
use Modules\Order\Models\Order;
use Modules\Product\Models\Product;

class CreateOrderAction
{
    /**
     * Create a new order.
     *
     * @param array $products
     * @return OrderResource
     */
    public function handle(array $order): OrderResource
    {
        $user = auth('sanctum')->user();

        return DB::transaction(function () use ($order, $user) {

            $totalAmount = 0;
            $items = [];

            foreach ($order['products'] as $product) {
                $productModel = Product::where('id', $product['id'])->select('id', 'price')->first();

                if (!$productModel) {
                    continue;
                }

                $price = $productModel->price;
                $quantity = $product['quantity'];
                $totalAmount += $price * $quantity;

                $items[] = [
                    'product_id' => $productModel->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ];
            }

            $order = new CreateOrderDTO($order['idempotency_key'], $user->customer->id, $totalAmount);
            $order = Order::create($order->toArray());

            foreach ($items as $item) {

                $itemDTO = new CreateOrderItemsDTO(
                    $item['product_id'],
                    $item['quantity'],
                    $item['price']
                );

                $order->items()->create($itemDTO->toArray());
            }

            return new OrderResource(
                $order->load('items.product')
            );
        });
    }
}
