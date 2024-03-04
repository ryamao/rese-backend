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
        path: '/customers/{customer}',
        tags: ['Customer'],
        summary: '顧客情報取得',
        description: 'セッション中の顧客情報を取得する',
    )]
    #[OA\PathParameter(ref: '#/components/parameters/customer-id')]
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
    public function show(User $customer): JsonResponse
    {
        Gate::allowIf(fn (User $authUser) => $customer->is($authUser));

        return response()->json(['name' => $customer->name]);
    }
}
