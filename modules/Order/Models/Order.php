<?php

declare(strict_types=1);

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Payment\Models\Payment;
use Modules\Shipment\Models\Shipment;

/**
 * @property-read string $customer_id
 * @property-read OrderStatusEnum $status
 * @property-read float $total_amount
 */
final class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'status',
        'total_amount'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'status'       => OrderStatusEnum::class
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    /**
     * Check if the order is still in progress.
     *
     * @return bool
     */
    public function isInProgress(): bool
    {
        return $this->status !== OrderStatusEnum::COMPLETED;
    }

    /**
     * Mark the order as completed.
     *
     * @throws \DomainException if the order is already completed.
     */
    public function markAsComplete(): void
    {
        if (!$this->isInProgress()) {
            throw new \DomainException('Order is already completed.');
        }

        $this->update([
            'status' => OrderStatusEnum::COMPLETED,
            'updated_at' => now()
        ]);
    }

    /**
     * Mark the order as cancelled.
     *
     * @throws \DomainException if the order is already completed.
     */
    public function markAsCancelled(): void
    {
        if (!$this->isInProgress()) {
            throw new \DomainException('Order is already completed and cannot be cancelled.');
        }

        $this->update([
            'status' => OrderStatusEnum::CANCELLED,
            'updated_at' => now()
        ]);
    }
}
