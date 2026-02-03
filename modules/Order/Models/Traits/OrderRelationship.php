<?php

declare(strict_types=1);

namespace Modules\Order\Models\Traits;

use Modules\Order\Models\OrderItem;
use Modules\Payment\Models\Payment;
use Modules\Shipment\Models\Shipment;

trait OrderRelationship
{
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
