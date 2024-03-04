<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Reservation
 */
class CustomerReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'shop' => new ShopIndexResource($this->shop),
            'reserved_at' => $this->reserved_at->toRfc3339String(),
            'number_of_guests' => $this->number_of_guests,
        ];
    }
}
