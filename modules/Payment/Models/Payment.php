<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Models\Order;

class Payment extends Model
{

    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'order_id',
        'payment_method',
        'amount',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
