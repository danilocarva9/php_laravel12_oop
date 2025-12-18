<?php

namespace Modules\Order\DTO;

use Modules\Order\Enums\OrderStatusEnum;
use Modules\Payment\Enums\PaymentStatusEnum;
use Modules\Shipment\Enums\ShipmentStatusEnum;

readonly class CreateOrderDTO
{

    public function __construct(
        public readonly string $idempotencyKey,
        public readonly int $customerId,
        public readonly float $totalAmount,
        public readonly OrderStatusEnum $status = OrderStatusEnum::PENDING,
        public readonly PaymentStatusEnum $paymentStatus = PaymentStatusEnum::UNPAID,
        public readonly ShipmentStatusEnum $shipmentStatus = ShipmentStatusEnum::PENDING,
    ) {}

    /**
     * Convert DTO to array for model creation
     */
    public function toArray(): array
    {
        return [
            'idempotency_key' => $this->idempotencyKey,
            'customer_id' => $this->customerId,
            'status' => $this->status->value,
            'payment_status' => $this->paymentStatus->value,
            'shipment_status' => $this->shipmentStatus->value,
            'total_amount' => $this->totalAmount
        ];
    }
}
