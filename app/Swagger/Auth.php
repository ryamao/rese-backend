<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

/**
 * Fortifyの認証機能に関するAPIを定義するクラス
 */
class Auth
{
    #[OA\Post(
        path: '/auth/register',
        tags: ['Auth'],
        summary: '会員登録',
        description: 'ユーザー(一般会員)を新規登録する',
    )]
    #[OA\RequestBody(
        ref: '#/components/requestBodies/post-auth-register'
    )]
    #[OA\Response(
        response: 201,
        ref: '#/components/responses/created',
    )]
    #[OA\Response(
        response: 302,
        ref: '#/components/responses/found',
    )]
    #[OA\Response(
        response: 422,
        ref: '#/components/responses/unprocessable-entity',
    )]
    public function register(): void
    {
    }
}
