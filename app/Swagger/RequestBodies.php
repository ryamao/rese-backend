<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: 'post-auth-register',
    description: '顧客登録リクエスト',
    required: true,
    content: new OA\JsonContent(
        required: ['name', 'email', 'password'],
        properties: [
            new OA\Property(
                property: 'name',
                description: '顧客名',
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

#[OA\RequestBody(
    request: 'post-customer-shop-reservations',
    description: '予約追加リクエスト',
    required: true,
    content: new OA\JsonContent(
        required: ['reserved_at', 'number_of_guests'],
        properties: [
            new OA\Property(
                property: 'reserved_at',
                description: '予約日時',
                type: 'string',
                format: 'date-time',
                example: '2021-12-31T23:59:59+09:00',
            ),
            new OA\Property(
                property: 'number_of_guests',
                description: '予約人数',
                type: 'integer',
                minimum: 1,
                example: 2,
            ),
        ]
    )
)]

class RequestBodies
{
}
