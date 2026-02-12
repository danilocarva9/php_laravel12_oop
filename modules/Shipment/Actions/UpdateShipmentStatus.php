<?php

namespace Modules\Shipment\Actions;

use Modules\Shipment\DTO\UpdateShipmentStatusDTO;
use Modules\Shipment\Models\Shipment;

class UpdateShipmentStatus
{

    /**
     * Update shipment status
     *
     * @param UpdateShipmentStatusDTO $data
     * @return void
     */
    public function handle(UpdateShipmentStatusDTO $data): void
    {
        $shipment = Shipment::where('tracking_number', $data->trackingNumber)
            ->firstOrFail();

        $shipment->updateStatus($data->status);
    }
}
