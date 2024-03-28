<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Reservation
 */
class ReservationResource extends JsonResource
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
            'shop' => CustomerShopResource::make($this->shop),
            'reserved_at' => $this->reserved_at->timezone('UTC')->format('Y-m-d\TH:i:sP'),
            'number_of_guests' => $this->number_of_guests,
            'is_checked_in' => $this->is_checked_in,
        ];
    }
}
