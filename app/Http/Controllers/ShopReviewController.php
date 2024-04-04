<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShopReviewResource;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ShopReviewController extends Controller
{
    #[OA\Get(
        operationId: 'get-shop-reviews',
        path: '/shops/{shop}/reviews',
        tags: ['Shop'],
        summary: 'レビュー一覧取得',
        description: '指定した店舗のレビュー一覧を取得する',
    )]
    #[OA\PathParameter(ref: '#/components/parameters/shop-id')]
    #[OA\QueryParameter(ref: '#/components/parameters/page-query')]
    #[OA\Response(response: '200', ref: '#/components/responses/get-shop-reviews-200')]
    #[OA\Response(response: '404', ref: '#/components/responses/not-found')]
    public function index(Shop $shop): JsonResponse
    {
        $reviews = $shop->reviews()->with(['user'])->paginate(10);

        return ShopReviewResource::collection($reviews)->response();
    }
}
