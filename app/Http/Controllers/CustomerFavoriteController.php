<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use OpenApi\Attributes as OA;

class CustomerFavoriteController extends Controller
{
    #[OA\Post(
        operationId: 'post-customer-shop-favorite',
        path: '/customers/{user}/shops/{shop}/favorite',
        tags: ['Favorite'],
        summary: 'お気に入り登録',
        description: 'ユーザー(一般会員)が飲食店をお気に入り登録する',
    )]
    #[OA\PathParameter(ref: '#/components/parameters/user-id')]
    #[OA\PathParameter(ref: '#/components/parameters/shop-id')]
    #[OA\Response(
        response: 201,
        ref: '#/components/responses/created',
    )]
    #[OA\Response(
        response: 401,
        ref: '#/components/responses/unauthorized',
    )]
    #[OA\Response(
        response: 403,
        ref: '#/components/responses/forbidden',
    )]
    #[OA\Response(
        response: 404,
        ref: '#/components/responses/not-found',
    )]
    #[OA\Response(
        response: 422,
        ref: '#/components/responses/unprocessable-entity',
    )]
    public function store(User $user, Shop $shop): Response
    {
        Gate::allowIf(fn (User $authUser) => $user->is($authUser));

        if ($user->favoriteShops()->where('shop_id', $shop->id)->exists()) {
            return response()->noContent(422);
        }

        $user->favoriteShops()->attach($shop);

        return response()->noContent(201);
    }

    #[OA\Delete(
        operationId: 'delete-customer-shop-favorite',
        path: '/customers/{user}/shops/{shop}/favorite',
        tags: ['Favorite'],
        summary: 'お気に入り解除',
        description: 'ユーザー(一般会員)が飲食店のお気に入りを解除する',
    )]
    #[OA\PathParameter(ref: '#/components/parameters/user-id')]
    #[OA\PathParameter(ref: '#/components/parameters/shop-id')]
    #[OA\Response(
        response: 204,
        ref: '#/components/responses/no-content',
    )]
    #[OA\Response(
        response: 401,
        ref: '#/components/responses/unauthorized',
    )]
    #[OA\Response(
        response: 403,
        ref: '#/components/responses/forbidden',
    )]
    #[OA\Response(
        response: 404,
        ref: '#/components/responses/not-found',
    )]
    #[OA\Response(
        response: 422,
        ref: '#/components/responses/unprocessable-entity',
    )]
    public function destroy(User $user, Shop $shop): Response
    {
        Gate::allowIf(fn (User $authUser) => $user->is($authUser));

        if ($user->favoriteShops()->where('shop_id', $shop->id)->doesntExist()) {
            return response()->noContent(422);
        }

        $user->favoriteShops()->detach($shop);

        return response()->noContent(204);
    }
}
