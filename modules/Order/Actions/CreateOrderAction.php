<?php

namespace Modules\Order\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Order\DTO\CreateOrderDTO;
use Modules\Order\DTO\CreateOrderItemsDTO;
use Modules\Order\Jobs\CreateOrderJob;
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
    public function handle(array $payload): Order
    {
        $customerId = auth('sanctum')->user()->customer->id;

        return DB::transaction(function () use ($payload, $customerId) {

            $orderDTO = new CreateOrderDTO($customerId);
            $order = Order::create($orderDTO->toArray());

            $products = Product::whereIn('id', collect($payload['products'])->pluck('id'))->get()->keyBy('id');

            foreach ($payload['products'] as $item) {
                $product = $products[$item['id']];

                $product->reduceStock($item['quantity']);

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->getPrice()
                ]);
            }

            // Dispatch job for further processing (e.g., sending confirmation email)
            CreateOrderJob::dispatch($order);

            Log::info("Order {$order->id} created for customer {$customerId}.");

            return $order;
        });
    }
}
