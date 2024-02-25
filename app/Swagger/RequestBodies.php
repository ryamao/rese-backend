<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: 'post-auth-register',
    description: 'ユーザー登録リクエスト',
    required: true,
    content: new OA\JsonContent(
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

class RequestBodies
{
}
