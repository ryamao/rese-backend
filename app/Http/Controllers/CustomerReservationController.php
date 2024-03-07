<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use OpenApi\Attributes as OA;

class CustomerReservationController extends Controller
{
    #[OA\Get(
        operationId: 'get-customer-reservations',
        path: '/customers/{customer}/reservations',
        tags: ['Reservation'],
        summary: 'マイページでの予約一覧取得機能',
        description: 'セッション中の顧客が行っている予約の一覧を取得する',
    )]
    #[OA\Parameter(ref: '#/components/parameters/customer-id')]
    #[OA\Response(response: 200, ref: '#/components/responses/get-customer-reservations-200')]
    #[OA\Response(response: 401, ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: 403, ref: '#/components/responses/forbidden')]
    #[OA\Response(response: 404, ref: '#/components/responses/not-found')]
    public function index(User $customer): JsonResponse
    {
        Gate::allowIf(fn (User $authUser) => $authUser->is($customer));

        $reservations = $customer->reservations()
            ->with('shop')
            ->whereDate('reserved_at', '>=', today())
            ->orderBy('reserved_at')
            ->get();

        return ReservationResource::collection($reservations)->response();
    }

    #[OA\Delete(
        operationId: 'delete-customer-reservations',
        path: '/customers/{customer}/reservations/{reservation}',
        tags: ['Reservation'],
        summary: 'マイページでの予約取り消し機能',
        description: 'セッション中の顧客が指定の飲食店で行っている指定の予約を取り消す',
    )]
    #[OA\Parameter(ref: '#/components/parameters/customer-id')]
    #[OA\Parameter(ref: '#/components/parameters/reservation-id')]
    #[OA\Response(response: 204, ref: '#/components/responses/no-content')]
    #[OA\Response(response: 401, ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: 403, ref: '#/components/responses/forbidden')]
    #[OA\Response(response: 404, ref: '#/components/responses/not-found')]
    public function destroy(User $customer, Reservation $reservation): Response
    {
        Gate::allowIf(fn (User $authUser) => $customer->is($authUser));
        Gate::allowIf(fn (User $authUser) => $reservation->user->is($authUser));

        $reservation->delete();

        return response()->noContent();
    }
}
