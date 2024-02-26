<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use OpenApi\Attributes as OA;

class CustomerController extends Controller
{
    #[OA\Get(
        operationId: 'get-customer',
        path: '/customers/{user}',
        tags: ['Customer'],
        summary: '会員情報取得',
        description: 'ユーザー(一般会員)の情報を取得する',
    )]
    #[OA\PathParameter(ref: '#/components/parameters/user-id')]
    #[OA\Response(
        response: 200,
        ref: '#/components/responses/show-customer-200',
    )]
    #[OA\Response(
        response: 401,
        ref: '#/components/responses/unauthorized',
    )]
    #[OA\Response(
        response: 403,
        ref: '#/components/responses/forbidden',
    )]
    #[OA\Response(
        response: 404,
        ref: '#/components/responses/not-found',
    )]
    public function show(User $user): JsonResponse
    {
        Gate::allowIf(fn (User $authUser) => $user->is($authUser));

        return response()->json(['name' => $user->name]);
    }
}
