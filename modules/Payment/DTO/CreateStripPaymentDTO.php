<?php

namespace Modules\Payment\DTO;

readonly class CreateStripPaymentDTO
{

    public function __construct(
        public readonly string $idempotencyKey,
        public readonly string $status
    ) {}

    /**
     * Convert DTO to array for model creation
     */
    public static function fromApi(array $array): self
    {
        return new self(
            idempotencyKey: $array['idempotency_key'],
            status: $array['status']
        );
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
