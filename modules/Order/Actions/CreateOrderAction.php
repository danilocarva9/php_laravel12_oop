<?php

namespace Modules\Order\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Customer\Models\Customer;
use Modules\Order\DTO\CreateOrderDTO;
use Modules\Order\DTO\CreateOrderItemsDTO;
use Modules\Order\Jobs\CreateOrderJob;
use Modules\Order\Models\Order;
use Modules\Product\Models\Product;

class CreateOrderAction
{
    /**
     * Handle the action to create a new order.
     *
     * @param array $request
     * @return Order
     */
    public function handle(Customer $customer, array $productsRequest): Order
    {
        return DB::transaction(function () use ($productsRequest, $customer) {

            $orderDTO = new CreateOrderDTO($customer->id);
            $order = Order::create($orderDTO->toArray());

            $products = Product::whereIn('id', collect($productsRequest)
                ->pluck('id'))
                ->get()
                ->keyBy('id');

            $orderItemsDTO = [];

            foreach ($productsRequest as $item) {
                $product = $products[$item['id']];

                $orderItemsDTO[] = (new CreateOrderItemsDTO(
                    productId: $product->id,
                    quantity: $item['quantity'],
                    price: $product->getPrice()
                ))->toArray();
            }

            $order->items()->createMany($orderItemsDTO);

            // Dispatch job for further processing (e.g., sending confirmation email)
            CreateOrderJob::dispatch($order);

            Log::info("Order {$order->id} created for customer {$customer->id}.");

            return $order;
        });
    }
}
