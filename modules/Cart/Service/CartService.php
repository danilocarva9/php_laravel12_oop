<?php

namespace Modules\Cart\Service;

use Illuminate\Support\Facades\Auth;
use Modules\Cart\Interfaces\CartInterface;
use Modules\Cart\Models\CartItem;
use Modules\Product\Models\Product;

class CartService implements CartInterface
{
    public function add(int $productId, int $quantity): array
    {
        $user = Auth::user();

        $product = Product::findOrFail($productId);

        if ($quantity > $product->stock) {
            throw new \InvalidArgumentException('Requested quantity exceeds available stock.');
        }

        return CartItem::updateOrCreate(
            [
                'customer_id' => $user->customer->id,
                'product_id' => $productId,
            ],
            [
                'quantity' => $quantity,
                'price' => $this->calculateTotal($product->price, $quantity),
            ]
        );
    }

    public function list(): ?array
    {
        // Simulate fetching an order
        return [
            'total' => 12312,
            'items' => [],
        ];
    }

    private function calculateTotal(float $price, int $quantity): float
    {
        return $price * $quantity;
    }
}
