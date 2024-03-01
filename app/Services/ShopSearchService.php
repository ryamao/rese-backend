<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ShopSearchService
{
    private readonly ?int $areaId;

    public function __construct(Request $request)
    {
        $this->areaId = $this->getAreaId($request);
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

        return $shops;
    }

    private function getAreaId(Request $request): ?int
    {
        if (filter_var($request->query('area'), FILTER_VALIDATE_INT) === false) {
            return null;
        }

        return (int) $request->query('area');
    }
}
