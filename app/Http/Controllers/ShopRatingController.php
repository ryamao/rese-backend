<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ShopRatingController extends Controller
{
    #[OA\Post(
        operationId: 'post-shop-rating',
        path: '/shops/{shop}/rating',
        tags: ['Shop'],
        summary: '5段階評価登録',
        description: '店舗に対して5段階評価を登録する',
    )]
    #[OA\PathParameter(ref: '#/components/parameters/shop-id')]
    #[OA\RequestBody(
        description: '評価情報',
        required: true,
        content: new OA\JsonContent(
            required: ['rating'],
            properties: [
                new OA\Property(
                    property: 'rating',
                    description: '評価',
                    type: 'integer',
                    minimum: 1,
                    maximum: 5,
                    example: 3,
                ),
            ]
        )
    )]
    #[OA\Response(response: 201, ref: '#/components/responses/created')]
    #[OA\Response(response: 401, ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: 403, ref: '#/components/responses/forbidden')]
    #[OA\Response(response: 404, ref: '#/components/responses/not-found')]
    #[OA\Response(response: 422, ref: '#/components/responses/unprocessable-entity')]
    public function store(): JsonResponse
    {
        throw new \Exception('Not implemented');
    }
}
