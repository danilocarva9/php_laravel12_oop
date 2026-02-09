<?php

namespace Modules\Order\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Models\Product;
use Modules\User\Models\User;
use Tests\TestCase;

class PlaceOrderFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_place_endpoint()
    {
        $user = User::factory()->create();
        $user->customer()->create([
            'user_id' => $user->id,
            'first_name' => 'Test 1',
            'last_name' => 'test last name'
        ]);

        $this->actAsUser($user);

        $productA = Product::factory()->create(['price' => 10000, 'stock' => 10]);
        $productB = Product::factory()->create(['price' => 20000, 'stock' => 5]);

        $response = $this->withHeaders([
            'Idempotency-Key' => (string) \Illuminate\Support\Str::uuid()
        ])->postJson('/api/order', [
            'products' => [
                [
                    'id' => $productA->id,
                    'quantity' => 2,
                ],
                [
                    'id' => $productB->id,
                    'quantity' => 3,
                ],
            ],
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'status',
                    'total_amount',
                    'items' => [
                        [
                            'quantity',
                            'name',
                            'price',
                        ],
                    ],
                ],
            ]);

        $this->assertDatabaseHas('orders', [
            'status' => 'PENDING',
        ]);
    }
}
