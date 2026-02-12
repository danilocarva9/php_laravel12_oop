<?php

namespace Modules\Shipment\DTO;

use Illuminate\Http\Request;
use Modules\Shipment\Enums\ShipmentStatusEnum;

final class UpdateShipmentStatusDTO
{
    public function __construct(
        public readonly string $trackingNumber,
        public readonly ShipmentStatusEnum $status,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            trackingNumber: $request->input('tracking_number'),
            status: ShipmentStatusEnum::from($request->input('status')),
        );
    }
}
