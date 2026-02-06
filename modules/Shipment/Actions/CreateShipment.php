<?php

namespace Modules\Shipment\Actions;

use Illuminate\Support\Facades\DB;
use Modules\Order\Models\Order;
use Modules\Shipment\Enums\ShipmentStatusEnum;
use Modules\Shipment\Models\Shipment;

class CreateShipment
{
    /**
     * Create a shipment for the given order.
     *
     * @param Order $order
     * @return void
     */
    public function handle(Order $order): void
    {
        Shipment::createShipment($order);
    }
}
