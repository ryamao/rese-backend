<?php

namespace App\Http\Controllers;

use App\Http\Resources\OwnerShopResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use OpenApi\Attributes as OA;

class OwnerShopController extends Controller
{
    #[OA\Get(
        path: '/owners/{owner}/shops',
        tags: ['Owner'],
        summary: '店舗代表者別店舗一覧取得',
        description: '店舗代表者が作成した飲食店情報の一覧を取得する',
    )]
    #[OA\PathParameter(ref: '#/components/parameters/owner-id')]
    #[OA\Response(response: 200, ref: '#/components/responses/get-owner-shops-200')]
    #[OA\Response(response: 401, ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: 403, ref: '#/components/responses/forbidden')]
    #[OA\Response(response: 404, ref: '#/components/responses/not-found')]
    public function index(User $owner): JsonResponse
    {
        Gate::allowIf(fn (User $authUser) => $authUser->is($owner));

        return OwnerShopResource::collection($owner->ownedShops)->response();
    }
}
