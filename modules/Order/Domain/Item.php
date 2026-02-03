<?php

declare(strict_types=1);

namespace Modules\Order\Domain;

use Modules\Product\Models\Product;

final class Item
{
    public function __construct(
        public Product $product,
        public int $quantity
    ) {}
}
