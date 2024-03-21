<?php

namespace App\Http\Controllers;

use App\Actions\CreateNewShop;
use App\Http\Requests\OwnerShopStoreRequest;
use App\Http\Resources\OwnerShopResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use OpenApi\Attributes as OA;

class OwnerShopController extends Controller
{
    #[OA\Get(
        operationId: 'get-owner-shops',
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

    #[OA\Post(
        operationId: 'post-owner-shops',
        path: '/owners/{owner}/shops',
        tags: ['Owner'],
        summary: '店舗代表者別店舗登録',
        description: '店舗代表者が飲食店情報を登録する',
    )]
    #[OA\PathParameter(ref: '#/components/parameters/owner-id')]
    #[OA\RequestBody(ref: '#/components/requestBodies/post-owner-shops')]
    #[OA\Response(response: 201, ref: '#/components/responses/post-owner-shops-201')]
    #[OA\Response(response: 401, ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: 403, ref: '#/components/responses/forbidden')]
    #[OA\Response(response: 404, ref: '#/components/responses/not-found')]
    #[OA\Response(response: 422, ref: '#/components/responses/post-owner-shops-422')]
    public function store(OwnerShopStoreRequest $request, User $owner): JsonResponse
    {
        Gate::allowIf(fn (User $authUser) => $authUser->is($owner));

        $shop = app(CreateNewShop::class)->create($request, $owner);

        return OwnerShopResource::make($shop)->response()->setStatusCode(201);
    }
}