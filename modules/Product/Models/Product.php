<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Cart\Models\CartItem;
use Modules\Order\Models\OrderItem;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'sku',
        'price',
        'stock'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function isInStock(int $quantity): bool
    {
        return $this->stock >= $quantity;
    }

    public function reduceStock(int $quantity): void
    {
        if ($this->isInStock($quantity)) {
            $this->decrement('stock', $quantity);
        } else {
            throw new \DomainException("Insufficient stock for product ID {$this->id}.");
        }
    }
}
