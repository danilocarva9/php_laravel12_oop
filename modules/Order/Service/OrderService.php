<?php

namespace Modules\Order\Service;

use Illuminate\Support\Facades\DB;
use Modules\Order\Exceptions\OrderNotFoundException;
use Modules\Order\Http\Resources\OrderResource;
use Modules\Order\Interfaces\OrderInterface;
use Modules\Order\Models\Order;
use Modules\Product\Models\Product;

class OrderService implements OrderInterface
{
    /**
     * Create a new order.
     *
     * @param array $products
     * @return Order
     */
    public function create(array $products): Order
    {
        $user = auth('sanctum')->user();

        return DB::transaction(function () use ($products, $user) {

            $totalAmount = 0;
            $items = [];

            foreach ($products as $product) {
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

            $order = Order::create([
                'customer_id' => $user->customer->id,
                'status' => 'PENDING',
                'payment_status' => 'UNPAID',
                'shipment_status' => 'PENDING',
                'total_amount' => $totalAmount
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            return $order;
        });
    }

    /**
     * Get an order by ID.
     *
     * @param int $id
     * @return Order
     * @throws OrderNotFoundException
     */
    public function get(int $id): OrderResource
    {
        $order = Order::find($id);

        if (!$order) {
            throw new OrderNotFoundException("Order not found");
        }

        return new OrderResource(
            $order->load('items.product')
        );
    }
}
