<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerReservationResource;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use OpenApi\Attributes as OA;

class CustomerReservationController extends Controller
{
    #[OA\Get(
        operationId: 'get-customer-shop-reservations',
        path: '/customers/{user}/shops/{shop}/reservations',
        tags: ['Reservation'],
        summary: '飲食店詳細ページの予約一覧取得',
        description: 'セッション中の会員が指定の飲食店で行っている予約を一覧取得する',
    )]
    #[OA\Parameter(
        ref: '#/components/parameters/user-id'
    )]
    #[OA\Parameter(
        ref: '#/components/parameters/shop-id'
    )]
    #[OA\Response(
        response: 200,
        ref: '#/components/responses/get-customer-shop-reservations-200'
    )]
    #[OA\Response(
        response: 401,
        ref: '#/components/responses/unauthorized',
    )]
    #[OA\Response(
        response: 403,
        ref: '#/components/responses/forbidden'
    )]
    #[OA\Response(
        response: 404,
        ref: '#/components/responses/not-found'
    )]
    public function index(User $user, Shop $shop): JsonResponse
    {
        Gate::allowIf(fn (User $authUser) => $user->is($authUser));

        $reservations = $user
            ->reservations()
            ->with('shop')
            ->where('shop_id', $shop->id)
            ->get();

        return response()->json([
            'reservations' => CustomerReservationResource::collection($reservations),
        ]);
    }
}
