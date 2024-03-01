<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AreaController extends Controller
{
    #[OA\Get(
        operationId: 'get-areas',
        path: '/areas',
        tags: ['Area'],
        summary: 'エリア一覧取得',
        description: 'エリア一覧を取得する',
    )]
    #[OA\Response(
        response: 200,
        ref: '#/components/responses/get-areas-200',
    )]
    public function index(): JsonResponse
    {
        return response()->json(
            [
                'areas' => [
                    ['id' => 1, 'name' => '東京'],
                    ['id' => 2, 'name' => '大阪'],
                    ['id' => 3, 'name' => '福岡'],
                ],
            ]
        );
    }
}
