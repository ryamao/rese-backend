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

    private readonly ?string $search;

    public function __construct(Request $request)
    {
        $this->areaId = $this->getId($request, 'area');
        $this->genreId = $this->getId($request, 'genre');
        $this->search = $this->getSearch($request);
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
        if ($this->search !== null) {
            $shops->where('name', 'like', "%{$this->search}%");
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

    private function getSearch(Request $request): ?string
    {
        $search = $request->query('search');

        if (is_array($search) || is_null($search)) {
            return null;
        }

        return addcslashes($search, '%_\\');
    }
}
