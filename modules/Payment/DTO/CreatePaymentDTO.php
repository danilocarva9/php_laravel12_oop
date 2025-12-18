<?php

namespace Modules\Payment\DTO;

readonly class CreatePaymentDTO
{

    public function __construct(
        public readonly string $idempotencyKey
    ) {}

    /**
     * Convert DTO to array for model creation
     */
    public function toArray(): array
    {
        return [
            'idempotency_key' => $this->idempotencyKey
        ];
    }
}
