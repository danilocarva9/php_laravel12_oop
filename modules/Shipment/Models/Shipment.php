<?php

namespace Modules\Shipment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Models\Order;
use Modules\Shipment\Enums\ShipmentStatusEnum;

class Shipment extends Model
{

    use HasFactory;

    protected $fillable = [
        'order_id',
        'tracking_number',
        'carrier',
        'status',
        'shipped_at',
        'delivered_at',
    ];

    protected $dates = [
        'shipped_at',
        'delivered_at',
    ];

    protected $cast = [
        'status' => ShipmentStatusEnum::class
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
