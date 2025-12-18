<?php

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Payment\Models\Payment;
use Modules\Shipment\Models\Shipment;

class Order extends Model
{

    use HasFactory;

    protected $fillable = [
        'idempotency_key',
        'customer_id',
        'status',
        'total_amount',
        'payment_status',
        'shipment_status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'status'       => OrderStatusEnum::class,
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
