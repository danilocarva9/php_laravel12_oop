<?php

namespace Modules\Cart\Interfaces;

interface CartInterface
{
    public function add(int $productId, int $quantity): array;

    public function list(): ?array;
}
