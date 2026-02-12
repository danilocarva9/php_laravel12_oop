<?php

namespace Modules\Shipment\Controllers;

use App\Http\Controllers\Controller;
use Modules\Shipment\Actions\UpdateShipmentStatus;
use Modules\Shipment\DTO\UpdateShipmentStatusDTO;
use Modules\Shipment\Http\Requests\UpdateStatusRequest;

class ShipmentController extends Controller
{
    public function updateStatus(UpdateStatusRequest $request, UpdateShipmentStatus $updateShipmentStatus)
    {
        $dto = UpdateShipmentStatusDTO::fromRequest($request);
        $updateShipmentStatus->handle($dto);

        return response()->json(['status' => 'success']);
    }
}
