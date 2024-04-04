<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopReviewRequest;
use App\Http\Resources\ShopReviewResource;
use App\Models\Review;
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

    #[OA\Post(
        operationId: 'post-shop-reviews',
        path: '/shops/{shop}/reviews',
        tags: ['Shop'],
        summary: 'レビュー投稿',
        description: '指定した店舗にレビューを投稿する',
    )]
    #[OA\PathParameter(ref: '#/components/parameters/shop-id')]
    #[OA\RequestBody(ref: '#/components/requestBodies/post-shop-reviews')]
    #[OA\Response(response: '201', ref: '#/components/responses/created')]
    #[OA\Response(response: '401', ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: '403', ref: '#/components/responses/forbidden')]
    #[OA\Response(response: '404', ref: '#/components/responses/not-found')]
    #[OA\Response(response: '422', ref: '#/components/responses/post-shop-reviews-422')]
    public function store(ShopReviewRequest $request, Shop $shop): JsonResponse
    {
        Review::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'shop_id' => $shop->id,
            ],
            $request->validated()
        );

        return response()->json('', 201);
    }
}
