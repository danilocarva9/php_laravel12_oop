<?php

namespace Modules\Shipment\Actions;

use Illuminate\Support\Facades\DB;
use Modules\Order\Models\Order;
use Modules\Shipment\Enums\ShipmentStatusEnum;
use Modules\Shipment\Models\Shipment;

class CreateShipmentAction
{
    /**
     * Create a shipment for the given order.
     *
     * @param Order $order
     * @return void
     */
    public function handle(Order $order)
    {
        return DB::transaction(function () use ($order) {
            Shipment::create([
                'order_id' => $order->id,
                'tracking_number' => 'TRK' . strtoupper(uniqid()),
                'carrier' => 'Default Carrier',
                'status' => ShipmentStatusEnum::PENDING,
            ]);
        });
    }
}
