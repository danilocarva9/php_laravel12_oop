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
            'total_amount'  => optional($this->payment)?->getTotalAmount(),
            'items' => OrderItemResource::collection($this->items),
        ];
    }
}
