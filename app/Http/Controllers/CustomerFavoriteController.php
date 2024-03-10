<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ShopResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use OpenApi\Attributes as OA;

class CustomerFavoriteController extends Controller
{
    #[OA\Get(
        operationId: 'get-customer-favorites',
        path: '/customers/{customer}/favorites',
        tags: ['Favorite'],
        summary: 'マイページでのお気に入り一覧取得機能',
        description: 'セッション中の顧客がお気に入り登録している飲食店の一覧を取得する',
    )]
    #[OA\PathParameter(ref: '#/components/parameters/customer-id')]
    #[OA\QueryParameter(ref: '#/components/parameters/page-query')]
    #[OA\Response(response: 200, ref: '#/components/responses/get-customer-favorites-200')]
    #[OA\Response(response: 401, ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: 403, ref: '#/components/responses/forbidden')]
    #[OA\Response(response: 404, ref: '#/components/responses/not-found')]
    public function index(User $customer): JsonResponse
    {
        Gate::allowIf(fn (User $authUser) => $authUser->is($customer));

        $shops = $customer->favoriteShops()->paginate(5);

        return ShopResource::collection($shops)->response();
    }
}
