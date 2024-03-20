<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CustomerShopResource;
use App\Models\Shop;
use App\Services\ShopSearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class ShopController extends Controller
{
    #[OA\Get(
        operationId: 'get-shops',
        path: '/shops',
        tags: ['Shop'],
        summary: '飲食店一覧取得',
        description: '飲食店一覧を取得する',
    )]
    #[OA\QueryParameter(ref: '#/components/parameters/area-query')]
    #[OA\QueryParameter(ref: '#/components/parameters/genre-query')]
    #[OA\QueryParameter(ref: '#/components/parameters/search-query')]
    #[OA\QueryParameter(ref: '#/components/parameters/page-query')]
    #[OA\Response(response: 200, ref: '#/components/responses/get-shops-200')]
    public function index(Request $request): AnonymousResourceCollection
    {
        $service = new ShopSearchService($request);

        $shops = $service->search()->paginate(10);

        return CustomerShopResource::collection($shops);
    }

    #[OA\Get(
        operationId: 'get-shop',
        path: '/shops/{shop}',
        tags: ['Shop'],
        summary: '飲食店情報取得',
        description: '飲食店情報を個別に取得する',
    )]
    #[OA\Parameter(ref: '#/components/parameters/shop-id')]
    #[OA\Response(response: 200, ref: '#/components/responses/get-shop-200')]
    #[OA\Response(response: 404, ref: '#/components/responses/not-found')]
    public function show(Shop $shop): JsonResponse
    {
        return CustomerShopResource::make($shop)->response();
    }
}
