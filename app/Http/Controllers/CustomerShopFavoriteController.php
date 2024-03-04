<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use OpenApi\Attributes as OA;

class CustomerShopFavoriteController extends Controller
{
    #[OA\Post(
        operationId: 'post-customer-shop-favorite',
        path: '/customers/{customer}/shops/{shop}/favorite',
        tags: ['Favorite'],
        summary: 'お気に入り登録',
        description: 'セッション中の顧客が指定の飲食店をお気に入り登録する',
    )]
    #[OA\PathParameter(ref: '#/components/parameters/customer-id')]
    #[OA\PathParameter(ref: '#/components/parameters/shop-id')]
    #[OA\Response(response: 201, ref: '#/components/responses/created')]
    #[OA\Response(response: 401, ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: 403, ref: '#/components/responses/forbidden')]
    #[OA\Response(response: 404, ref: '#/components/responses/not-found')]
    #[OA\Response(response: 422, ref: '#/components/responses/unprocessable-entity')]
    public function store(User $customer, Shop $shop): JsonResponse
    {
        Gate::allowIf(fn (User $authUser) => $customer->is($authUser));

        if ($customer->favoriteShops()->where('shop_id', $shop->id)->exists()) {
            return response()->json(null, 422);
        }

        $customer->favoriteShops()->attach($shop);

        return response()->json(null, 201);
    }

    #[OA\Delete(
        operationId: 'delete-customer-shop-favorite',
        path: '/customers/{customer}/shops/{shop}/favorite',
        tags: ['Favorite'],
        summary: 'お気に入り解除',
        description: 'セッション中の顧客が指定の飲食店のお気に入りを解除する',
    )]
    #[OA\PathParameter(ref: '#/components/parameters/customer-id')]
    #[OA\PathParameter(ref: '#/components/parameters/shop-id')]
    #[OA\Response(response: 204, ref: '#/components/responses/no-content')]
    #[OA\Response(response: 401, ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: 403, ref: '#/components/responses/forbidden')]
    #[OA\Response(response: 404, ref: '#/components/responses/not-found')]
    #[OA\Response(response: 422, ref: '#/components/responses/unprocessable-entity')]
    public function destroy(User $customer, Shop $shop): Response
    {
        Gate::allowIf(fn (User $authUser) => $customer->is($authUser));

        if ($customer->favoriteShops()->where('shop_id', $shop->id)->doesntExist()) {
            return response()->noContent(422);
        }

        $customer->favoriteShops()->detach($shop);

        return response()->noContent(204);
    }
}
