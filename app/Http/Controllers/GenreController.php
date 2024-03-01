<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class GenreController extends Controller
{
    #[OA\Get(
        operationId: 'get-genres',
        path: '/genres',
        tags: ['Genre'],
        summary: 'ジャンル一覧取得',
        description: 'ジャンル一覧を取得する',
    )]
    #[OA\Response(
        response: 200,
        ref: '#/components/responses/get-genres-200',
    )]
    public function index(): JsonResponse
    {
        return response()->json();
    }
}
