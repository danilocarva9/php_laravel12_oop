<?php

namespace Modules\Order\DTO;

readonly class CreateOrderItemsDTO
{
    public function __construct(
        public readonly int $productId,
        public readonly int $quantity,
        public readonly int $price
    ) {}

    /**
     * Convert DTO to array for model creation
     */
    public function toArray(): array
    {
        return [
            'product_id' => $this->productId,
            'quantity' => $this->quantity,
            'price' => $this->price
        ];
    }
}
