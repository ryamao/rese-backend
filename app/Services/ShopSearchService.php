<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ShopSearchService
{
    private readonly ?int $areaId;

    private readonly ?int $genreId;

    public function __construct(Request $request)
    {
        $this->areaId = $this->getId($request, 'area');
        $this->genreId = $this->getId($request, 'genre');
    }

    /**
     * @return Builder<\App\Models\Shop>
     */
    public function search(): Builder
    {
        $shops = Shop::with(['area', 'genre']);

        if ($this->areaId !== null) {
            $shops->where('area_id', $this->areaId);
        }
        if ($this->genreId !== null) {
            $shops->where('genre_id', $this->genreId);
        }

        return $shops;
    }

    private function getId(Request $request, string $key): ?int
    {
        if (filter_var($request->query($key), FILTER_VALIDATE_INT) === false) {
            return null;
        }

        return (int) $request->query($key);
    }
}
