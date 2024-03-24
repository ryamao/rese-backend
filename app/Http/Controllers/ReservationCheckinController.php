<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ReservationCheckinController extends Controller
{
    #[OA\Get(
        operationId: 'get-reservation-signed-url',
        path: '/reservations/{reservation}/signed-url',
        tags: ['Reservations'],
        summary: '入店確認URL取得',
        description: '入店確認用の署名付きURLを取得する',
    )]
    #[OA\PathParameter(ref: '#/components/parameters/reservation-id')]
    #[OA\Response(response: '200', ref: '#/components/responses/get-reservation-signed-url-200')]
    #[OA\Response(response: '401', ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: '403', ref: '#/components/responses/forbidden')]
    #[OA\Response(response: '404', ref: '#/components/responses/not-found')]
    public function signedUrl(Reservation $reservation): JsonResponse
    {
        throw new \Exception('Not implemented');
    }
}
