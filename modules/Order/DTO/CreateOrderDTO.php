<?php

namespace Modules\Order\DTO;

use Modules\Order\Enums\OrderStatusEnum;

readonly class CreateOrderDTO
{

    public function __construct(
        public readonly int $customerId,
        public readonly float $totalAmount,
        public readonly OrderStatusEnum $status = OrderStatusEnum::PENDING,
    ) {}

    /**
     * Convert DTO to array for model creation
     */
    public function toArray(): array
    {
        return [
            'customer_id' => $this->customerId,
            'status' => $this->status->value,
            'total_amount' => $this->totalAmount
        ];
    }
}
