<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Shop
 */
class OwnerShopResource extends JsonResource
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
            'area' => $this->area->only('id', 'name'),
            'genre' => $this->genre->only('id', 'name'),
            'name' => $this->name,
            'image_url' => $this->image_url,
            'detail' => $this->detail,
        ];
    }
}
