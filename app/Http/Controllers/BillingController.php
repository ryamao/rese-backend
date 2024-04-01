<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillingRequest;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use OpenApi\Attributes as OA;

class BillingController extends Controller
{
    #[OA\Post(
        operationId: 'post-reservation-billing',
        path: '/reservations/{reservation}/billing',
        tags: ['Payment'],
        summary: '請求金額登録',
        description: '予約に対して請求金額を登録する',
    )]
    #[OA\PathParameter(ref: '#/components/parameters/reservation-id')]
    #[OA\RequestBody(
        description: '請求金額',
        required: true,
        content: new OA\JsonContent(
            required: ['amount', 'description'],
            properties: [
                new OA\Property(
                    property: 'amount',
                    description: '請求金額',
                    type: 'integer',
                    minimum: 1,
                    example: 3000,
                ),
                new OA\Property(
                    property: 'description',
                    description: '請求内容',
                    type: 'string',
                    example: 'サンプルテキスト',
                ),
            ]
        )
    )]
    #[OA\Response(response: 201, ref: '#/components/responses/created')]
    #[OA\Response(response: 401, ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: 403, ref: '#/components/responses/forbidden')]
    #[OA\Response(response: 404, ref: '#/components/responses/not-found')]
    #[OA\Response(response: 409, ref: '#/components/responses/conflict')]
    #[OA\Response(response: 422, ref: '#/components/responses/unprocessable-entity')]
    public function store(BillingRequest $request, Reservation $reservation): JsonResponse
    {
        Gate::allowIf(fn ($authUser) => $authUser->is($reservation->shop->owner));

        if ($reservation->billing) {
            return response()->json('', 409);
        }

        $reservation->billing()->create([
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        return response()->json('', 201);
    }
}
