<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationForOwnersResource;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use OpenApi\Attributes as OA;

class OwnerShopReservationController extends Controller
{
    #[OA\Get(
        operationId: 'get-owner-shop-reservations',
        path: '/owners/{owner}/shops/{shop}/reservations',
        tags: ['Owner'],
        summary: '店舗代表者向け飲食店別予約一覧取得',
        description: '店舗代表者と飲食店を指定して予約一覧を取得する',
    )]
    #[OA\PathParameter(ref: '#/components/parameters/owner-id')]
    #[OA\PathParameter(ref: '#/components/parameters/shop-id')]
    #[OA\QueryParameter(ref: '#/components/parameters/page-query')]
    #[OA\Response(response: 200, ref: '#/components/responses/get-owner-shop-reservations-200')]
    #[OA\Response(response: 401, ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: 403, ref: '#/components/responses/forbidden')]
    #[OA\Response(response: 404, ref: '#/components/responses/not-found')]
    public function index(User $owner, Shop $shop): JsonResponse
    {
        Gate::allowIf(fn (User $authUser) => $authUser->is($owner) && $authUser->is($shop->owner));

        $reservations = $shop->reservations()
            ->with(['user', 'billing'])
            ->orderBy('reserved_at')
            ->paginate(10);

        return ReservationForOwnersResource::collection($reservations)->response();
    }
}
