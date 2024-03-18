<?php

namespace App\Http\Controllers;

use App\Http\Requests\OwnerStoreRequest;
use App\Models\User;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;
use Spatie\Permission\Models\Role;

class OwnerController extends Controller
{
    #[OA\Post(
        operationId: 'post-owners',
        path: '/owners',
        tags: ['Admin'],
        summary: '店舗代表者追加',
        description: '店舗代表者アカウントを追加する',
    )]
    #[OA\RequestBody(ref: '#/components/requestBodies/post-owners')]
    #[OA\Response(response: 201, ref: '#/components/responses/created')]
    #[OA\Response(response: 401, ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: 403, ref: '#/components/responses/forbidden')]
    #[OA\Response(response: 422, ref: '#/components/responses/unprocessable-entity')]
    public function store(OwnerStoreRequest $request): Response
    {
        $owner = User::create($request->validated());
        $owner->assignRole(Role::findOrCreate('owner'));

        return response('', 201);
    }
}
