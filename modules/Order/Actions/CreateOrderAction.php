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
     * @return Order
     */
    public function handle(array $payload, int $customerId): Order
    {
        return DB::transaction(function () use ($payload, $customerId) {

            $totalAmount = 0;
            $items = [];

            $productsInput = collect($payload['products']);

            $products = Product::whereIn('id', $productsInput->pluck('id'))->select('id', 'price', 'stock')->get()->keyBy('id');

            foreach ($productsInput as $productData) {

                $product = $products->get($productData['id']);

                if (!$product) {
                    throw new \DomainException("Product with ID {$productData['id']} not found.");
                }

                $product->reduceStock($productData['quantity']);

                $quantity = $productData['quantity'];
                $totalAmount += $product->price * $quantity;

                $items[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ];
            }

            $orderDTO = new CreateOrderDTO(
                $customerId,
                $totalAmount
            );

            $order = Order::create($orderDTO->toArray());

            foreach ($items as $item) {
                $order->items()->create(
                    (new CreateOrderItemsDTO(
                        $item['product_id'],
                        $item['quantity'],
                        $item['price']
                    ))->toArray()
                );
            }

            return $order->load('items.product');
        });
    }
}
