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
            schema: new OA\Schema(type: 'string', example: 'XSRF-TOKEN=eyJpdiI6Ij')
        ),
    ]
)]

#[OA\Response(
    response: 'get-auth-status-200',
    description: '認証状態取得成功',
    content: new OA\JsonContent(
        ref: '#/components/schemas/auth-status',
        examples: [
            'guest' => new OA\Examples(
                example: 'guest',
                ref: '#/components/examples/get-auth-status-200-guest'
            ),
            'customer-unverified' => new OA\Examples(
                example: 'customer-unverified',
                ref: '#/components/examples/get-auth-status-200-customer-unverified'
            ),
            'customer-verified' => new OA\Examples(
                example: 'customer-verified',
                ref: '#/components/examples/get-auth-status-200-customer-verified'
            ),
        ]
    )
)]

#[OA\Response(
    response: 'post-owners-422',
    description: 'バリデーションエラーまたはメールアドレスが登録済み',
    content: new OA\JsonContent(
        ref: '#/components/schemas/register-error',
    )
)]

#[OA\Response(
    response: 'post-notification-email-422',
    description: 'バリデーションエラー',
    content: new OA\JsonContent(
        ref: '#/components/schemas/notification-email-error',
        examples: [
            'required' => new OA\Examples(
                example: 'required',
                ref: '#/components/examples/post-notification-email-422-required'
            ),
        ]
    )
)]

#[OA\Response(
    response: 'post-auth-register-422',
    description: 'バリデーションエラーまたはメールアドレスが登録済み',
    content: new OA\JsonContent(
        ref: '#/components/schemas/register-error',
        examples: [
            'required' => new OA\Examples(
                example: 'required',
                ref: '#/components/examples/post-auth-register-422-required'
            ),
            'email' => new OA\Examples(
                example: 'invalid-email',
                ref: '#/components/examples/post-auth-register-422-email'
            ),
            'password' => new OA\Examples(
                example: 'password',
                ref: '#/components/examples/post-auth-register-422-password'
            ),
        ]
    )
)]

#[OA\Response(
    response: 'post-auth-login-422',
    description: 'バリデーションエラーまたは未登録',
    content: new OA\JsonContent(
        ref: '#/components/schemas/login-error',
        examples: [
            'required' => new OA\Examples(
                example: 'required',
                ref: '#/components/examples/post-auth-login-422-required'
            ),
            'email' => new OA\Examples(
                example: 'email',
                ref: '#/components/examples/post-auth-login-422-email'
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
                items: new OA\Items(ref: '#/components/schemas/area-data')
            ),
        ],
        examples: [
            'example' => new OA\Examples(
                example: 'example',
                ref: '#/components/examples/get-areas-200'
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
                items: new OA\Items(ref: '#/components/schemas/genre-data')
            ),
        ],
        examples: [
            'example' => new OA\Examples(
                example: 'example',
                ref: '#/components/examples/get-genres-200'
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
                        items: new OA\Items(ref: '#/components/schemas/customer-shop-data')
                    ),
                ],
            ),
        ],
        examples: [
            'first-page' => new OA\Examples(
                example: 'first-page',
                ref: '#/components/examples/get-shops-200-first-page'
            ),
            'middle-page' => new OA\Examples(
                example: 'middle-page',
                ref: '#/components/examples/get-shops-200-middle-page'
            ),
            'last-page' => new OA\Examples(
                example: 'last-page',
                ref: '#/components/examples/get-shops-200-last-page'
            ),
            'empty' => new OA\Examples(
                example: 'empty',
                ref: '#/components/examples/get-shops-200-empty'
            ),
        ]
    ),
)]

#[OA\Response(
    response: 'get-shop-200',
    description: '飲食店情報取得成功',
    content: new OA\JsonContent(
        type: 'object',
        required: ['data'],
        properties: [
            new OA\Property(
                property: 'data',
                ref: '#/components/schemas/customer-shop-data'
            ),
        ],
        examples: [
            'example' => new OA\Examples(
                example: 'example',
                ref: '#/components/examples/get-shop-200'
            ),
        ]
    )
)]

#[OA\Response(
    response: 'get-customer-favorites-200',
    description: 'マイページのお気に入り一覧取得成功',
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
                        items: new OA\Items(ref: '#/components/schemas/customer-shop-data')
                    ),
                ],
            ),
        ],
        examples: [
            'example' => new OA\Examples(
                example: 'example',
                ref: '#/components/examples/get-customer-favorites-200'
            ),
        ]
    )
)]

#[OA\Response(
    response: 'get-customer-reservations-200',
    description: 'マイページの予約一覧取得成功',
    content: new OA\JsonContent(
        type: 'object',
        required: ['data'],
        properties: [
            new OA\Property(
                property: 'data',
                type: 'array',
                items: new OA\Items(ref: '#/components/schemas/reservation-data')
            ),
        ],
    )
)]

#[OA\Response(
    response: 'get-customer-shop-reservations-200',
    description: '飲食店詳細ページの予約一覧取得成功',
    content: new OA\JsonContent(
        type: 'object',
        required: ['reservations'],
        properties: [
            new OA\Property(
                property: 'reservations',
                type: 'array',
                items: new OA\Items(ref: '#/components/schemas/reservation-data')
            ),
        ],
        examples: [
            'example' => new OA\Examples(
                example: 'example',
                ref: '#/components/examples/get-customer-shop-reservations-200-example'
            ),
            'empty' => new OA\Examples(
                example: 'empty',
                ref: '#/components/examples/get-customer-shop-reservations-200-empty'
            ),
        ]
    ),
)]

#[OA\Response(
    response: 'post-customer-shop-reservations-201',
    description: '飲食店詳細ページの予約追加成功',
    content: new OA\JsonContent(
        type: 'object',
        required: ['reservation'],
        properties: [
            new OA\Property(property: 'reservation', ref: '#/components/schemas/reservation-data'),
        ],
        examples: [
            'example' => new OA\Examples(
                example: 'example',
                ref: '#/components/examples/post-customer-shop-reservations-201'
            ),
        ]
    )
)]

#[OA\Response(
    response: 'post-customer-shop-reservations-422',
    description: '飲食店詳細ページの予約追加のバリデーションエラー',
    content: new OA\JsonContent(
        ref: '#/components/schemas/reservation-error',
        examples: [
            'required' => new OA\Examples(
                example: 'required',
                ref: '#/components/examples/post-customer-shop-reservations-422-required'
            ),
            'reserved_at' => new OA\Examples(
                example: 'date',
                ref: '#/components/examples/post-customer-shop-reservations-422-reserved_at'
            ),
            'past' => new OA\Examples(
                example: 'past',
                ref: '#/components/examples/post-customer-shop-reservations-422-past'
            ),
            'number_of_guests' => new OA\Examples(
                example: 'number_of_guests',
                ref: '#/components/examples/post-customer-shop-reservations-422-number_of_guests'
            ),
        ]
    )
)]

#[OA\Response(
    response: 'put-customer-reservation-422',
    description: 'マイページの予約変更のバリデーションエラー',
    content: new OA\JsonContent(
        ref: '#/components/schemas/reservation-error',
        examples: [
            'required' => new OA\Examples(
                example: 'required',
                ref: '#/components/examples/post-customer-shop-reservations-422-required'
            ),
            'reserved_at' => new OA\Examples(
                example: 'date',
                ref: '#/components/examples/post-customer-shop-reservations-422-reserved_at'
            ),
            'past' => new OA\Examples(
                example: 'past',
                ref: '#/components/examples/post-customer-shop-reservations-422-past'
            ),
            'number_of_guests' => new OA\Examples(
                example: 'number_of_guests',
                ref: '#/components/examples/post-customer-shop-reservations-422-number_of_guests'
            ),
        ]
    )
)]

#[OA\Response(
    response: 'get-owner-shops-200',
    description: '店舗代表者別店舗一覧取得成功',
    content: new OA\JsonContent(
        type: 'object',
        required: ['data'],
        properties: [
            new OA\Property(
                property: 'data',
                type: 'array',
                items: new OA\Items(ref: '#/components/schemas/owner-shop-data')
            ),
        ],
    )
)]

#[OA\Response(
    response: 'post-owner-shops-201',
    description: '店舗代表者別店舗登録成功',
    content: new OA\JsonContent(
        type: 'object',
        required: ['data'],
        properties: [
            new OA\Property(property: 'data', ref: '#/components/schemas/owner-shop-data'),
        ],
    )
)]

#[OA\Response(
    response: 'post-owner-shops-422',
    description: '店舗代表者別店舗登録のバリデーションエラー',
    content: new OA\JsonContent(
        ref: '#/components/schemas/create-shop-error',
        examples: [
            'required' => new OA\Examples(
                example: 'required',
                ref: '#/components/examples/post-owner-shops-422-required'
            ),
        ]
    )
)]

#[OA\Response(
    response: 'put-owner-shop-422',
    description: '店舗代表者別店舗更新のバリデーションエラー',
    content: new OA\JsonContent(
        ref: '#/components/schemas/create-shop-error'
    )
)]

#[OA\Response(
    response: 'get-owner-shop-reservations-200',
    description: '店舗代表者向け飲食店別予約一覧取得成功',
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
                        items: new OA\Items(ref: '#/components/schemas/reservation-for-owner')
                    ),
                ],
            ),
        ],
    ),
)]

#[OA\Response(
    response: 'get-reservation-signed-url-200',
    description: '入店確認URL取得成功',
    content: new OA\JsonContent(
        type: 'object',
        required: ['url'],
        properties: [
            new OA\Property(property: 'url', type: 'string', format: 'uri'),
        ],
        examples: [
            'example' => new OA\Examples(
                example: 'example',
                summary: '入店確認URL取得成功',
                value: 'https://api.web-no-benkyo.com/reservations/1/checkin?signature=eyJpdiI6Ij',
            ),
        ]
    ),
)]

#[OA\Response(
    response: 'get-create-intent-200',
    description: '決済インテント取得成功',
    content: new OA\JsonContent(
        type: 'object',
        required: ['client_secret'],
        properties: [
            new OA\Property(property: 'client_secret', type: 'string'),
        ],
        examples: [
            'example' => new OA\Examples(
                example: 'example',
                summary: '決済インテント取得成功',
                value: 'pi_1J4J1v2eZvKYlo2C5J4J1v2eZvKYlo2C',
            ),
        ]
    ),
)]

#[OA\Response(
    response: 'get-shop-reviews-200',
    description: 'レビュー一覧取得成功',
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
                        items: new OA\Items(ref: '#/components/schemas/shop-review-data')
                    ),
                ],
            ),
        ],
    ),
)]

#[OA\Response(
    response: 'post-shop-reviews-422',
    description: 'レビュー投稿のバリデーションエラー',
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
                        property: 'rating',
                        type: 'array',
                        items: new OA\Items(
                            type: 'string'
                        )
                    ),
                    new OA\Property(
                        property: 'comment',
                        type: 'array',
                        items: new OA\Items(
                            type: 'string'
                        )
                    ),
                ]
            ),
        ],
    )
)]

class Responses
{
}
