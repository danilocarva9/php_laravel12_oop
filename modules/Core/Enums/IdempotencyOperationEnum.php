<?php

namespace Modules\Core\Enums;

use Illuminate\Support\Str;

enum IdempotencyOperationEnum: string
{
    case ORDER_CREATION = 'ORDER_CREATION';
    case PURCHASE = 'PURCHASE';

    public function label(): string
    {
        return Str::headLine($this->value);
    }
}
