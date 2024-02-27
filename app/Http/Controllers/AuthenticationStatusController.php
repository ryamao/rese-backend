<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AuthenticationStatusController extends Controller
{
    #[OA\Get(
        operationId: 'get-auth-status',
        path: '/auth/status',
        tags: ['Auth'],
        summary: '認証状態取得',
        description: '認証状態を取得する',
    )]
    #[OA\Response(
        response: 200,
        ref: '#/components/responses/get-auth-status-200',
    )]
    public function show(): JsonResponse
    {
        return response()->json(['status' => 'ok']);
    }
}
