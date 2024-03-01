<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Types\FavoriteStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Shop
 */
class ShopIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $favoriteStatus = FavoriteStatus::Unknown;
        if ($request->user()) {
            if ($request->user()->favoriteShops->contains('id', $this->id)) {
                $favoriteStatus = FavoriteStatus::Marked;
            } else {
                $favoriteStatus = FavoriteStatus::Unmarked;
            }
        }

        return [
            'id' => $this->id,
            'area' => $this->area->name,
            'genre' => $this->genre->name,
            'name' => $this->name,
            'image_url' => $this->image_url,
            'favorite_status' => $favoriteStatus,
        ];
    }
}
