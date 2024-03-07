<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerReservationStoreRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use OpenApi\Attributes as OA;

class CustomerShopReservationController extends Controller
{
    #[OA\Get(
        operationId: 'get-customer-shop-reservations',
        path: '/customers/{customer}/shops/{shop}/reservations',
        tags: ['Reservation'],
        summary: '飲食店詳細ページでの予約一覧取得機能',
        description: 'セッション中の顧客が指定の飲食店で行っている予約を一覧取得する',
    )]
    #[OA\Parameter(ref: '#/components/parameters/customer-id')]
    #[OA\Parameter(ref: '#/components/parameters/shop-id')]
    #[OA\Response(response: 200, ref: '#/components/responses/get-customer-shop-reservations-200')]
    #[OA\Response(response: 401, ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: 403, ref: '#/components/responses/forbidden')]
    #[OA\Response(response: 404, ref: '#/components/responses/not-found')]
    public function index(User $customer, Shop $shop): JsonResponse
    {
        Gate::allowIf(fn (User $authUser) => $customer->is($authUser));

        $reservations = $customer
            ->reservations()
            ->with('shop')
            ->where('shop_id', $shop->id)
            ->whereDate('reserved_at', '>=', today())
            ->orderBy('reserved_at')
            ->get();

        return response()->json([
            'reservations' => ReservationResource::collection($reservations),
        ]);
    }

    #[OA\Post(
        operationId: 'post-customer-shop-reservations',
        path: '/customers/{customer}/shops/{shop}/reservations',
        tags: ['Reservation'],
        summary: '飲食店詳細ページでの予約追加機能',
        description: 'セッション中の顧客が指定の飲食店で予約を追加する',
    )]
    #[OA\Parameter(ref: '#/components/parameters/customer-id')]
    #[OA\Parameter(ref: '#/components/parameters/shop-id')]
    #[OA\RequestBody(ref: '#/components/requestBodies/post-customer-shop-reservations')]
    #[OA\Response(response: 201, ref: '#/components/responses/post-customer-shop-reservations-201')]
    #[OA\Response(response: 401, ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: 403, ref: '#/components/responses/forbidden')]
    #[OA\Response(response: 404, ref: '#/components/responses/not-found')]
    #[OA\Response(response: 422, ref: '#/components/responses/post-customer-shop-reservations-422')]
    public function store(CustomerReservationStoreRequest $request, User $customer, Shop $shop): JsonResponse
    {
        $reservation = Reservation::create([
            'user_id' => $customer->id,
            'shop_id' => $shop->id,
            'reserved_at' => Carbon::make($request->input('reserved_at'))?->timezone('UTC'),
            'number_of_guests' => $request->input('number_of_guests'),
        ]);

        return response()->json([
            'reservation' => new ReservationResource($reservation),
        ], 201);
    }
}
