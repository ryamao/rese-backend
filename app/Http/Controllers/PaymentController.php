<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class PaymentController extends Controller
{
    #[OA\Post(
        operationId: 'post-reservation-payment',
        path: '/reservations/{reservation}/payment',
        tags: ['Payment'],
        summary: '決済',
        description: '予約に対して決済を行う',
    )]
    #[OA\PathParameter(ref: '#/components/parameters/reservation-id')]
    #[OA\RequestBody(
        description: '決済情報',
        required: true,
        content: new OA\JsonContent(
            required: ['confirmation_token_id'],
            properties: [
                new OA\Property(
                    property: 'confirmation_token_id',
                    description: '確認トークンID',
                    type: 'string',
                    example: 'pi_1J3J1v2eZvKYlo2C5J9z1J3J',
                ),
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: '決済成功',
        content: new OA\JsonContent(
            type: 'string',
        ),
    )]
    #[OA\Response(response: 401, ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: 403, ref: '#/components/responses/forbidden')]
    #[OA\Response(response: 404, ref: '#/components/responses/not-found')]
    #[OA\Response(response: 422, ref: '#/components/responses/unprocessable-entity')]
    public function store(PaymentRequest $request, Reservation $reservation): JsonResponse
    {
        if ($reservation->billing === null) {
            return response()->json('請求情報がありません', 422);
        }
        if ($reservation->billing->is_paid) {
            return response()->json('既に支払い済みです', 422);
        }

        /** @var string */
        $secret = config('cashier.secret');

        $stripe = new \Stripe\StripeClient($secret);

        $paymentIntent = $stripe->paymentIntents->create([
            'confirm' => true,
            'amount' => $reservation->billing->amount,
            'currency' => 'jpy',
            'description' => $reservation->billing->description,
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
            'confirmation_token' => $request->confirmation_token_id,
            'return_url' => env('SPA_URL').'/mypage',
        ]);

        if ($paymentIntent->status === 'succeeded') {
            $reservation->billing->update(['is_paid' => true]);

            return response()->json($paymentIntent->status, 201);
        } else {
            return response()->json($paymentIntent->status, 422);
        }
    }
}
