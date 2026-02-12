<?php

declare(strict_types=1);

namespace Modules\Shipment\Models;

use DomainException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InvalidArgumentException;
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

    protected $casts = [
        'status' => ShipmentStatusEnum::class,
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public static function createShipment(Order $order): self
    {
        return $order->shipment()->create([
            'tracking_number' => self::generateTrackingNumber(),
            'carrier' => 'Default Carrier',
            'status' => ShipmentStatusEnum::PENDING,
        ]);
    }

    private static function generateTrackingNumber(): string
    {
        return 'TRK' . strtoupper(uniqid());
    }

    private function markAsShipped(): void
    {
        if (in_array($this->status, [
            ShipmentStatusEnum::PENDING
        ], true)) {
            throw new DomainException('Order cannot be shipped.');
        }
    }

    private function markAsInTransit(): void
    {
        if (in_array($this->status, [
            ShipmentStatusEnum::DELIVERED,
            ShipmentStatusEnum::FAILED,
        ], true)) {
            throw new DomainException('Order cannot be in transit.');
        }
    }

    private function markAsOutForDelivery(): void
    {
        if (in_array($this->status, [
            ShipmentStatusEnum::PENDING,
            ShipmentStatusEnum::PROCESSING,
        ], true)) {
            throw new DomainException('The shipment cant be delivered.');
        }
    }

    private function markAsDelivered(): void
    {
        if (in_array($this->status, [
            ShipmentStatusEnum::FAILED,
            ShipmentStatusEnum::RETURNED,
            ShipmentStatusEnum::CANCELLED,
        ], true)) {
            throw new DomainException('The shipment cant be delivered.');
        }
    }

    public function updateStatus(ShipmentStatusEnum $status): void
    {
        match ($status) {
            ShipmentStatusEnum::SHIPPED => $this->markAsShipped(),
            ShipmentStatusEnum::IN_TRANSIT => $this->markAsInTransit(),
            ShipmentStatusEnum::OUT_FOR_DELIVERY => $this->markAsOutForDelivery(),
            ShipmentStatusEnum::DELIVERED => $this->markAsDelivered(),
            default => throw new DomainException('Invalid shipment status transition')
        };

        $this->update([
            'status' => $status,
            'updated_at' => now(),
        ]);
    }
}
