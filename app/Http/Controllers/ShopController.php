<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ShopController extends Controller
{
    #[OA\Get(
        path: '/shops',
        tags: ['Shop'],
        summary: '飲食店一覧取得',
        description: '飲食店一覧を取得する',
    )]
    #[OA\QueryParameter(ref: '#/components/parameters/area-query')]
    #[OA\QueryParameter(ref: '#/components/parameters/genre-query')]
    #[OA\QueryParameter(ref: '#/components/parameters/search-query')]
    #[OA\Response(
        response: 200,
        ref: '#/components/responses/get-shops-200'
    )]
    public function index(): JsonResponse
    {
        return response()->json();
    }
}
