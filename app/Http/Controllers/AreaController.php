<?php

namespace App\Http\Controllers;

use App\Models\Area;
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
        return response()->json([
            'areas' => Area::select('id', 'name')->get(),
        ]);
    }
}
