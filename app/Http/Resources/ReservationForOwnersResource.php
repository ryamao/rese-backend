<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Reservation
 */
class ReservationForOwnersResource extends JsonResource
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
            'customer_name' => $this->user->name,
            'reserved_at' => $this->reserved_at->timezone('UTC')->format('Y-m-d\TH:i:sP'),
            'number_of_guests' => $this->number_of_guests,
            'is_checked_in' => $this->is_checked_in,
            'billing' => $this->billing ? [
                'amount' => $this->billing->amount,
                'description' => $this->billing->description,
                'is_paid' => $this->billing->is_paid,
            ] : null,
        ];
    }
}
