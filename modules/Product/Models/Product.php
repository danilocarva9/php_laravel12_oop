<?php

declare(strict_types=1);

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Cart\Models\CartItem;
use Modules\Order\Models\OrderItem;

/**
 * @property-read string $name
 * @property-read string|null $description
 * @property-read string $sku
 * @property-read int $price
 * @property-read int $stock
 */
final class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'sku',
        'price', //currently in integer cents pennies to avoid float precision issues
        'stock'
    ];

    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer'
    ];

    protected static function newFactory()
    {
        return \Modules\Product\Database\Factories\ProductFactory::new();
    }

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
        if (!$this->isInStock($quantity)) {
            throw new \DomainException("Insufficient stock for product ID {$this->name}.");
        }

        $this->decrement('stock', $quantity);
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
