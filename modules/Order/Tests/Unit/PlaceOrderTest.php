<?php

namespace Modules\Order\Tests\Unit;

use DomainException;
use Modules\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Customer\Models\Customer;
use Modules\Order\Actions\PlaceOrder;
use Modules\Product\Models\Product;
use Tests\TestCase;

class PlaceOrderTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Customer $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->customer = $this->user->customer()->create(['first_name' => 'Peter', 'last_name' => 'Parker']);
    }

    public function test_it_should_place_an_order_with_items_and_total()
    {
        $productA = Product::factory()->create(['price' => 10000, 'stock' => 10]);
        $productB = Product::factory()->create(['price' => 20000, 'stock' => 5]);

        $payload = [
            'idempotency_key' => uniqid('order_', true),
            'products' => [
                ['id' => $productA->id, 'quantity' => 2],
                ['id' => $productB->id, 'quantity' => 1],
            ],
        ];

        $action = new PlaceOrder(new \Modules\Payment\Actions\CreatePayment());

        $order = $action->handle($this->customer, $payload['products']);

        // Check if order exists in database
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'customer_id' => $this->customer->id
        ]);

        //Checks if payment register was created.
        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
            'amount' => $order->payment->amount
        ]);

        //Checks order amount (NOT IN CENTS) and items
        $this->assertEquals(400, $order->payment->getTotalAmount());
        $this->assertCount(2, $order->items);

        // Check each order item
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $productA->id,
            'quantity' => 2,
            'price' => 10000,
        ]);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $productB->id,
            'quantity' => 1,
            'price' => 20000,
        ]);
    }

    public function test_it_should_not_create_order_because_some_product_is_out_of_stock()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Some products are out of stock.');

        $user = User::factory()->create();
        $customer = $user->customer()->create(['first_name' => 'Peter', 'last_name' => 'Parker']);

        $productA = Product::factory()->create(['price' => 10000, 'stock' => 10]);
        $productB = Product::factory()->create(['price' => 20000, 'stock' => 1]);

        $payload = [
            'idempotency_key' => uniqid('order_', true),
            'products' => [
                ['id' => $productA->id, 'quantity' => 2],
                ['id' => $productB->id, 'quantity' => 2],
            ],
        ];

        $action = new PlaceOrder(new \Modules\Payment\Actions\CreatePayment());

        $action->handle($customer, $payload['products']);
    }
}
