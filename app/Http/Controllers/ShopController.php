<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ShopIndexResource;
use App\Services\ShopSearchService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class ShopController extends Controller
{
    #[OA\Get(
        path: '/shops',
        tags: ['Shop'],
        summary: '飲食店一覧取得',
        description: '飲食店一覧を取得する',
    )]
    #[OA\QueryParameter(ref: '#/components/parameters/area-query')]
    #[OA\QueryParameter(ref: '#/components/parameters/genre-query')]
    #[OA\QueryParameter(ref: '#/components/parameters/search-query')]
    #[OA\QueryParameter(ref: '#/components/parameters/page-query')]
    #[OA\Response(
        response: 200,
        ref: '#/components/responses/get-shops-200'
    )]
    public function index(Request $request): AnonymousResourceCollection
    {
        $service = new ShopSearchService($request);

        $shops = $service->search()->paginate(10);

        return ShopIndexResource::collection($shops);
    }
}
