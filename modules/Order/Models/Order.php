<?php

declare(strict_types=1);

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Customer\Models\Customer;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Order\Models\Traits\OrderRelationship;
use Modules\Payment\Models\Payment;
use Modules\Product\Models\Product;
use Modules\Shipment\Models\Shipment;

/**
 * @property-read string $customer_id
 * @property-read OrderStatusEnum $status
 */
final class Order extends Model
{
    use HasFactory, OrderRelationship;

    protected $fillable = [
        'customer_id',
        'status'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'status'       => OrderStatusEnum::class
    ];

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
     * Check if the order is completed.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->status === OrderStatusEnum::COMPLETED;
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

    /**
     * Place a new order for the given customer with specified items.
     *
     * @param Customer $customer
     * @param array $items
     * @return Order
     */
    public static function place(Customer $customer, array $items): Order
    {
        return DB::transaction(function () use ($customer, $items) {
            $order = self::create([
                'customer_id' => $customer->id,
                'status' => OrderStatusEnum::PENDING,
            ]);

            $items = collect($items)->map(fn($product) => [
                'product_id' => $product['id'],
                'quantity'   => $product['quantity'],
                'price'      => Product::findOrFail($product['id'])->getPrice(),
            ]);

            $order->items()->createMany($items->toArray());

            return $order;
        });
    }
}
