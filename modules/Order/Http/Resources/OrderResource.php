<?php

namespace Modules\Order\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'status'        => $this->status,
            'total_amount'  => $this->total_amount,
            'payment_status' => $this->payment_status,
            'shipment_status' => $this->shipment_status,
            'items' => OrderItemResource::collection($this->items),
        ];
    }
}
