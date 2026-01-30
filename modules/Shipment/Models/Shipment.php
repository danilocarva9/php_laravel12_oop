<?php

namespace Modules\Shipment\Models;

declare(strict_types=1);

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Models\Order;
use Modules\Shipment\Enums\ShipmentStatusEnum;

/**
 * @property-read int $order_id
 * @property-read string $tracking_number
 * @property-read string|null $carrier
 * @property-read ShipmentStatusEnum $status
 * @property-read \DateTime|null $shipped_at
 * @property-read \DateTime|null $delivered_at
 */
final class Shipment extends Model
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
