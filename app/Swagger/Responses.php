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

#[OA\Response(
    response: 'get-shops-200',
    description: '飲食店一覧取得成功',
    content: new OA\JsonContent(
        allOf: [
            new OA\Schema(ref: '#/components/schemas/pagination'),
            new OA\Schema(
                type: 'object',
                required: ['data'],
                properties: [
                    new OA\Property(
                        property: 'data',
                        type: 'array',
                        items: new OA\Items(
                            type: 'object',
                            required: ['id', 'name', 'area', 'genre', 'image_url', 'favorite_status'],
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
                                new OA\Property(
                                    property: 'area',
                                    type: 'string',
                                ),
                                new OA\Property(
                                    property: 'genre',
                                    type: 'string',
                                ),
                                new OA\Property(
                                    property: 'image_url',
                                    type: 'string',
                                    format: 'uri',
                                ),
                                new OA\Property(
                                    property: 'favorite_status',
                                    type: 'string',
                                    enum: ['unknown', 'marked', 'unmarked'],
                                ),
                            ]
                        )
                    ),
                ],
            ),
        ],
        examples: [
            'empty' => new OA\Examples(
                example: 'get-shops-200-empty',
                summary: '該当する飲食店がない場合',
                value: [
                    'meta' => [
                        'current_page' => 1,
                        'from' => 0,
                        'last_page' => 1,
                        'path' => 'https://api.rese.com/shops',
                        'per_page' => 10,
                        'to' => 0,
                        'total' => 0,
                    ],
                    'links' => [
                        ['url' => null, 'label' => '&laquo; Previous', 'active' => false],
                        ['url' => 'https://api.rese.com/shops?page=1', 'label' => '1', 'active' => true],
                        ['url' => null, 'label' => 'Next &raquo;', 'active' => false],
                    ],
                    'data' => [],
                ]
            ),
            'first-page' => new OA\Examples(
                example: 'get-shops-200-first-page',
                summary: '1ページ目の飲食店一覧',
                value: [
                    'meta' => [
                        'current_page' => 1,
                        'from' => 1,
                        'last_page' => 3,
                        'path' => 'https://api.rese.com/shops',
                        'per_page' => 5,
                        'to' => 5,
                        'total' => 12,
                    ],
                    'links' => [
                        ['url' => null, 'label' => '&laquo; Previous', 'active' => false],
                        ['url' => 'https://api.rese.com/shops?page=1', 'label' => '1', 'active' => true],
                        ['url' => 'https://api.rese.com/shops?page=2', 'label' => '2', 'active' => true],
                        ['url' => 'https://api.rese.com/shops?page=3', 'label' => '3', 'active' => true],
                        ['url' => 'https://api.rese.com/shops?page=2', 'label' => 'Next &raquo;', 'active' => true],
                    ],
                    'data' => [
                        ['id' => 1, 'name' => '店舗1', 'area' => '東京', 'genre' => '和食', 'image_url' => 'https://api.rese.com/images/1.jpg', 'favorite_status' => 'unknown'],
                        ['id' => 2, 'name' => '店舗2', 'area' => '大阪', 'genre' => '中華', 'image_url' => 'https://api.rese.com/images/2.jpg', 'favorite_status' => 'marked'],
                        ['id' => 3, 'name' => '店舗3', 'area' => '福岡', 'genre' => 'イタリアン', 'image_url' => 'https://api.rese.com/images/3.jpg', 'favorite_status' => 'unmarked'],
                        ['id' => 4, 'name' => '店舗4', 'area' => '東京', 'genre' => '和食', 'image_url' => 'https://api.rese.com/images/4.jpg', 'favorite_status' => 'unknown'],
                        ['id' => 5, 'name' => '店舗5', 'area' => '大阪', 'genre' => '中華', 'image_url' => 'https://api.rese.com/images/5.jpg', 'favorite_status' => 'marked'],
                    ],
                ]
            ),
            'middle-page' => new OA\Examples(
                example: 'get-shops-200-middle-page',
                summary: '2ページ目の飲食店一覧',
                value: [
                    'meta' => [
                        'current_page' => 2,
                        'from' => 6,
                        'last_page' => 3,
                        'path' => 'https://api.rese.com/shops',
                        'per_page' => 5,
                        'to' => 10,
                        'total' => 12,
                    ],
                    'links' => [
                        ['url' => 'https://api.rese.com/shops?page=1', 'label' => '&laquo; Previous', 'active' => true],
                        ['url' => 'https://api.rese.com/shops?page=1', 'label' => '1', 'active' => true],
                        ['url' => 'https://api.rese.com/shops?page=2', 'label' => '2', 'active' => true],
                        ['url' => 'https://api.rese.com/shops?page=3', 'label' => '3', 'active' => true],
                        ['url' => 'https://api.rese.com/shops?page=3', 'label' => 'Next &raquo;', 'active' => true],
                    ],
                    'data' => [
                        ['id' => 6, 'name' => '店舗6', 'area' => '福岡', 'genre' => 'イタリアン', 'image_url' => 'https://api.rese.com/images/6.jpg', 'favorite_status' => 'unmarked'],
                        ['id' => 7, 'name' => '店舗7', 'area' => '東京', 'genre' => '和食', 'image_url' => 'https://api.rese.com/images/7.jpg', 'favorite_status' => 'unknown'],
                        ['id' => 8, 'name' => '店舗8', 'area' => '大阪', 'genre' => '中華', 'image_url' => 'https://api.rese.com/images/8.jpg', 'favorite_status' => 'marked'],
                        ['id' => 9, 'name' => '店舗9', 'area' => '福岡', 'genre' => 'イタリアン', 'image_url' => 'https://api.rese.com/images/9.jpg', 'favorite_status' => 'unmarked'],
                        ['id' => 10, 'name' => '店舗10', 'area' => '東京', 'genre' => '和食', 'image_url' => 'https://api.rese.com/images/10.jpg', 'favorite_status' => 'unknown'],
                    ],
                ]
            ),
            'last-page' => new OA\Examples(
                example: 'get-shops-200-last-page',
                summary: '3ページ目の飲食店一覧',
                value: [
                    'meta' => [
                        'current_page' => 3,
                        'from' => 11,
                        'last_page' => 3,
                        'path' => 'https://api.rese.com/shops',
                        'per_page' => 5,
                        'to' => 12,
                        'total' => 12,
                    ],
                    'links' => [
                        ['url' => 'https://api.rese.com/shops?page=2', 'label' => '&laquo; Previous', 'active' => true],
                        ['url' => 'https://api.rese.com/shops?page=1', 'label' => '1', 'active' => true],
                        ['url' => 'https://api.rese.com/shops?page=2', 'label' => '2', 'active' => true],
                        ['url' => 'https://api.rese.com/shops?page=3', 'label' => '3', 'active' => true],
                        ['url' => null, 'label' => 'Next &raquo;', 'active' => false],
                    ],
                    'data' => [
                        ['id' => 11, 'name' => '店舗11', 'area' => '大阪', 'genre' => '中華', 'image_url' => 'https://api.rese.com/images/11.jpg', 'favorite_status' => 'marked'],
                        ['id' => 12, 'name' => '店舗12', 'area' => '福岡', 'genre' => 'イタリアン', 'image_url' => 'https://api.rese.com/images/12.jpg', 'favorite_status' => 'unmarked'],
                    ],
                ]
            ),
        ]
    ),
)]

class Responses
{
}
