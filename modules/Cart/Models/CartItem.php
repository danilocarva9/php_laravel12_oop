<?php

namespace Modules\Cart\Models;

declare(strict_types=1);

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Customer\Models\Customer;
use Modules\Product\Models\Product;

/**
 * @property-read int $customer_id
 * @property-read int $product_id
 * @property-read int $quantity
 * @property-read float $price
 */
final class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';

    protected $fillable = [
        'customer_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $cast = [
        'quantity' => 'integer',
        'price' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
