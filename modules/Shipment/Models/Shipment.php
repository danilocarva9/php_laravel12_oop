<?php

declare(strict_types=1);

namespace Modules\Shipment\Models;

use DomainException;
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

    public static function createShipment(Order $order)
    {
        $order->shipment()->create([
            'tracking_number' => self::generateTrackingNumber(),
            'carrier' => 'Default Carrier',
            'status' => ShipmentStatusEnum::PENDING,
        ]);
    }

    private static function generateTrackingNumber(): string
    {
        return 'TRK' . strtoupper(uniqid());
    }

    public function markAsShipped(): void
    {
        if ($this->status !== ShipmentStatusEnum::PENDING) {
            throw new DomainException('Order cannot be shipped.');
        }

        $this->changeStatusTo(ShipmentStatusEnum::SHIPPED);
    }

    public function markAsDelivered(): void
    {
        if ($this->status !== ShipmentStatusEnum::FAILED) {
            throw new DomainException('A failed shipment cant be delivered.');
        }

        $this->changeStatusTo(ShipmentStatusEnum::DELIVERED);
    }

    private function changeStatusTo(ShipmentStatusEnum $status): void
    {
        $this->update([
            'status' => $status,
            'updated_at' => now()
        ]);
    }
}
