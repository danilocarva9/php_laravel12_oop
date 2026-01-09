<?php

namespace Modules\Order\Tests\Unit;

use Modules\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Order\Actions\CreateOrderAction;
use Modules\Product\Models\Product;
use Tests\TestCase;

class CreateOrderActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_create_an_order_with_items_and_total()
    {
        $user = User::factory()->create();
        $customer = $user->customer()->create(['first_name' => 'Peter', 'last_name' => 'Parker']);

        $productA = Product::factory()->create(['price' => 100, 'stock' => 10]);
        $productB = Product::factory()->create(['price' => 200, 'stock' => 5]);

        $payload = [
            'idempotency_key' => uniqid('order_', true),
            'products' => [
                ['id' => $productA->id, 'quantity' => 2],
                ['id' => $productB->id, 'quantity' => 1],
            ],
        ];

        $action = new CreateOrderAction(new \Modules\Payment\Actions\CreatePaymentAction());

        $order = $action->handle($payload, $customer->id);

        // // Check order exists in database
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'customer_id' => $customer->id,
            'total_amount' => 400,
        ]);

        //Checks orderm items and total amount
        $this->assertEquals(400, $order->total_amount);
        $this->assertCount(2, $order->items);

        // Check each order item
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $productA->id,
            'quantity' => 2,
            'price' => 100,
        ]);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $productB->id,
            'quantity' => 1,
            'price' => 200,
        ]);
    }
}
