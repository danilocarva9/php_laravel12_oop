<?php

namespace Modules\Cart\Interfaces;

interface CartInterface
{
    public function create(array $data): array;

    public function get(int $cartId): ?array;
}
