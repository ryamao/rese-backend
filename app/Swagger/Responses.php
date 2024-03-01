<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Response(
    response: 'ok',
    description: 'リクエストが成功しリソースが見つかった',
)]

#[OA\Response(
    response: 'created',
    description: 'リクエストが成功しリソースが作成された',
)]

#[OA\Response(
    response: 'no-content',
    description: 'リクエストが成功しリソースが存在しない',
)]

#[OA\Response(
    response: 'found',
    description: 'リクエストが成功しリソースが見つかった',
)]

#[OA\Response(
    response: 'unauthorized',
    description: '認証エラー',
)]

#[OA\Response(
    response: 'forbidden',
    description: '認可エラー',
)]

#[OA\Response(
    response: 'not-found',
    description: '指定されたリソースが存在しない',
)]

#[OA\Response(
    response: 'conflict',
    description: 'リクエストが競合している',
)]

#[OA\Response(
    response: 'unprocessable-entity',
    description: 'リクエストが正しくない',
)]

#[OA\Response(
    response: 'get-sanctum-csrf-cookie-204',
    description: 'CSRFトークン取得成功',
    headers: [
        new OA\Header(
            header: 'Set-Cookie',
            description: 'CSRFトークンをCookieにセット',
            required: true,
            schema: new OA\Schema(
                type: 'string',
                example: 'XSRF-TOKEN=eyJpdiI6Ij',
            )
        ),
    ]
)]

#[OA\Response(
    response: 'post-auth-register-422',
    description: 'バリデーションエラーまたはメールアドレスが登録済み',
    content: new OA\JsonContent(
        type: 'object',
        required: ['message', 'errors'],
        properties: [
            new OA\Property(
                property: 'message',
                type: 'string'
            ),
            new OA\Property(
                property: 'errors',
                type: 'object',
                properties: [
                    new OA\Property(
                        property: 'name',
                        type: 'array',
                        items: new OA\Items(
                            type: 'string'
                        )
                    ),
                    new OA\Property(
                        property: 'email',
                        type: 'array',
                        items: new OA\Items(
                            type: 'string'
                        )
                    ),
                    new OA\Property(
                        property: 'password',
                        type: 'array',
                        items: new OA\Items(
                            type: 'string'
                        )
                    ),
                ]
            ),
        ],
        examples: [
            'required' => new OA\Examples(
                example: 'post-auth-register-422-required',
                summary: '名前、メールアドレス、パスワードが入力されていない場合',
                value: [
                    'message' => '名前を入力してください (and 2 more errors)',
                    'errors' => [
                        'name' => ['名前を入力してください'],
                        'email' => ['メールアドレスを入力してください'],
                        'password' => ['パスワードを入力してください'],
                    ],
                ]
            ),
            'email' => new OA\Examples(
                example: 'post-auth-register-422-email',
                summary: 'メールアドレスが正しい形式でない場合',
                value: [
                    'message' => 'メールアドレスを正しい形式で入力してください',
                    'errors' => [
                        'email' => ['メールアドレスを正しい形式で入力してください'],
                    ],
                ]
            ),
            'password' => new OA\Examples(
                example: 'post-auth-register-422-password',
                summary: 'パスワードが8文字未満の場合',
                value: [
                    'message' => 'パスワードは8文字以上で入力してください',
                    'errors' => [
                        'password' => ['パスワードは8文字以上で入力してください'],
                    ],
                ]
            ),
        ]
    )
)]

#[OA\Response(
    response: 'post-auth-login-422',
    description: 'バリデーションエラーまたは未登録',
    content: new OA\JsonContent(
        type: 'object',
        required: ['message', 'errors'],
        properties: [
            new OA\Property(
                property: 'message',
                type: 'string'
            ),
            new OA\Property(
                property: 'errors',
                type: 'object',
                properties: [
                    new OA\Property(
                        property: 'email',
                        type: 'array',
                        items: new OA\Items(
                            type: 'string'
                        )
                    ),
                    new OA\Property(
                        property: 'password',
                        type: 'array',
                        items: new OA\Items(
                            type: 'string'
                        )
                    ),
                ]
            ),
        ],
        examples: [
            'required' => new OA\Examples(
                example: 'post-auth-login-422-required',
                summary: 'メールアドレス、パスワードが入力されていない場合',
                value: [
                    'message' => 'メールアドレスを入力してください (and 1 more error)',
                    'errors' => [
                        'email' => ['メールアドレスを入力してください'],
                        'password' => ['パスワードを入力してください'],
                    ],
                ]
            ),
            'email' => new OA\Examples(
                example: 'post-auth-login-422-email',
                summary: 'ユーザーが登録されていない場合',
                value: [
                    'message' => '認証情報が登録されていません',
                    'errors' => [
                        'email' => ['認証情報が登録されていません'],
                    ],
                ]
            ),
        ]
    )
)]

#[OA\Response(
    response: 'get-auth-status-200',
    description: '認証状態取得成功',
    content: new OA\JsonContent(
        type: 'object',
        required: ['status'],
        properties: [
            new OA\Property(
                property: 'status',
                type: 'string',
                enum: ['guest', 'customer']
            ),
            new OA\Property(
                property: 'id',
                type: 'integer',
                format: 'int64'
            ),
        ],
        examples: [
            'guest' => new OA\Examples(
                example: 'get-auth-status-200-guest',
                summary: '未認証の状態',
                value: [
                    'status' => 'guest',
                ]
            ),
            'customer' => new OA\Examples(
                example: 'get-auth-status-200-customer',
                summary: '一般会員として認証済みの状態',
                value: [
                    'status' => 'customer',
                    'id' => 1,
                ]
            ),
        ]
    )
)]

#[OA\Response(
    response: 'get-areas-200',
    description: 'エリア一覧取得成功',
    content: new OA\JsonContent(
        type: 'object',
        required: ['areas'],
        properties: [
            new OA\Property(
                property: 'areas',
                type: 'array',
                items: new OA\Items(
                    type: 'object',
                    required: ['id', 'name'],
                    properties: [
                        new OA\Property(
                            property: 'id',
                            type: 'integer',
                            format: 'int64'
                        ),
                        new OA\Property(
                            property: 'name',
                            type: 'string'
                        ),
                    ]
                )
            ),
        ],
        examples: [
            'example' => new OA\Examples(
                example: 'get-areas-200-example',
                summary: 'エリア一覧の例',
                value: [
                    'areas' => [
                        ['id' => 1, 'name' => '東京'],
                        ['id' => 2, 'name' => '大阪'],
                        ['id' => 3, 'name' => '福岡'],
                    ],
                ]
            ),
        ]
    )
)]

#[OA\Response(
    response: 'get-genres-200',
    description: 'ジャンル一覧取得成功',
    content: new OA\JsonContent(
        type: 'object',
        required: ['genres'],
        properties: [
            new OA\Property(
                property: 'genres',
                type: 'array',
                items: new OA\Items(
                    type: 'object',
                    required: ['id', 'name'],
                    properties: [
                        new OA\Property(
                            property: 'id',
                            type: 'integer',
                            format: 'int64'
                        ),
                        new OA\Property(
                            property: 'name',
                            type: 'string'
                        ),
                    ]
                )
            ),
        ],
        examples: [
            'example' => new OA\Examples(
                example: 'get-genres-200-example',
                summary: 'ジャンル一覧の例',
                value: [
                    'genres' => [
                        ['id' => 1, 'name' => '和食'],
                        ['id' => 2, 'name' => '中華'],
                        ['id' => 3, 'name' => 'イタリアン'],
                    ],
                ]
            ),
        ]
    )
)]

class Responses
{
}
