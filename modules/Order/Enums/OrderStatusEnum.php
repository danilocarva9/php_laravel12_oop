<?php

namespace Modules\Order\Enums;

use Illuminate\Support\Str;

enum OrderStatusEnum: string
{
    case PENDING = 'PENDING';
    case PROCESSING = 'PROCESSING';
    case COMPLETED = 'COMPLETED';
    case CANCELLED = 'CANCELLED';
}
