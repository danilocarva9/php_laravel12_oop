<?php

declare(strict_types=1);

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Models\Order;
use Modules\Payment\Enums\PaymentStatusEnum;

/**
 * @property-read string $transaction_id
 * @property-read int $order_id
 * @property-read string $payment_method
 * @property-read int $amount
 * @property-read PaymentStatusEnum $status
 */
final class Payment extends Model
{

    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'order_id',
        'payment_method',
        'amount',
        'status'
    ];

    public function casts(): array
    {
        return [
            'amount' => 'integer',
            'status' => PaymentStatusEnum::class,
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Check if the payment is paid.
     *
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->status === PaymentStatusEnum::PAID;
    }

    /**
     * Mark the payment as paid.
     *
     * @return void
     */
    public function markAsPaid(): void
    {
        if ($this->isPaid()) {
            throw new \DomainException('Payment is already marked as paid.');
        }

        $this->update(['status' => PaymentStatusEnum::PAID, 'updated_at' => now()]);
    }

    public function getTotalAmount(): float
    {
        return $this->amount / 100;
    }
}
