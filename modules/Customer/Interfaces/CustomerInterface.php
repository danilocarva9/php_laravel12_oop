<?php

namespace Modules\Customer\Interfaces;

interface CustomerInterface
{
    public function create(array $data): array;

    public function get(int $cartId): ?array;
}
