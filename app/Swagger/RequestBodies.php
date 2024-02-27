<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: 'post-auth-register',
    description: 'ユーザー登録リクエスト',
    required: true,
    content: new OA\JsonContent(
        required: ['name', 'email', 'password'],
        properties: [
            new OA\Property(
                property: 'name',
                description: 'ユーザー名',
                type: 'string',
                minLength: 1,
                maxLength: 100,
                example: 'テストユーザー',
            ),
            new OA\Property(
                property: 'email',
                description: 'メールアドレス',
                type: 'string',
                format: 'email',
                example: 'test@example.com',
            ),
            new OA\Property(
                property: 'password',
                description: 'パスワード',
                type: 'string',
                minLength: 8,
                maxLength: 100,
                example: 'password',
            ),
        ]
    )
)]

#[OA\RequestBody(
    request: 'post-auth-login',
    description: 'ログインリクエスト',
    required: true,
    content: new OA\JsonContent(
        required: ['email', 'password'],
        properties: [
            new OA\Property(
                property: 'email',
                description: 'メールアドレス',
                type: 'string',
                format: 'email',
                example: 'test@example.com',
            ),
            new OA\Property(
                property: 'password',
                description: 'パスワード',
                type: 'string',
                minLength: 8,
                maxLength: 100,
                example: 'password',
            ),
        ]
    )
)]

class RequestBodies
{
}
