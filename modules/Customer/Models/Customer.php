<?php

declare(strict_types=1);

namespace Modules\Customer\Models;

use Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Cart\Models\CartItem;

/**
 * @property-read int $user_id
 * @property-read string $first_name
 * @property-read string $last_name
 */
final class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
