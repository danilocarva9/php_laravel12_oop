<?php

namespace Modules\Payment\Enums;

use Illuminate\Support\Str;

enum PaymentStatusEnum: string
{
    case UNPAID = 'UNPAID';
    case PAID = 'PAID';
}
