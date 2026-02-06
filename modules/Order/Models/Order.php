<?php

declare(strict_types=1);

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Customer\Models\Customer;
use Modules\Order\Domain\Item;
use Modules\Order\Domain\Items;
use Modules\Order\Enums\OrderStatusEnum;
use Modules\Payment\Models\Payment;
use Modules\Shipment\Models\Shipment;

/**
 * @property-read string $customer_id
 * @property-read OrderStatusEnum $status
 */
final class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'status'
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

    public function shipment()
    {
        return $this->hasOne(Shipment::class);
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
     * @param Items $items
     * @return self
     */
    public static function place(Customer $customer, Items $items): self
    {
        $order = self::create([
            'customer_id' => $customer->id,
            'status' => OrderStatusEnum::PENDING,
        ]);

        foreach ($items->items as $item) {
            $order->addItem($item);
        }

        return $order;
    }

    /**
     * Add items to order
     *
     * @param Item $item
     * @return void
     */
    private function addItem(Item $item): void
    {
        if (!$item->product->isInStock($item->quantity)) {
            throw new \DomainException('Some products are out of stock.');
        }

        $this->items()->save(new OrderItem([
            'product_id' => $item->product->id,
            'quantity' => $item->quantity,
            'price' => $item->product->price
        ]));
    }

    /**
     * Calculate the total amount for the order items.
     *
     * @return integer
     */
    public function calculateTotal(): int
    {
        return $this->items->sum(
            fn($item) =>
            $item->price * $item->quantity
        );
    }
}
