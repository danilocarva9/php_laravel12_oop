<?php

declare(strict_types=1);

namespace Modules\Order\Domain;

use Modules\Product\Models\Product;

final class Items
{
    public function __construct(
        /** @var \Modules\Order\Models\Item[] $items */
        public array $items
    ) {}

    public static function fromArray(array $input): self
    {
        $items = collect($input)
            ->map(fn(array $item) => new Item(
                product: Product::find($item['id']),
                quantity: $item['quantity']
            ))->all();

        return new self(items: $items);
    }
}
