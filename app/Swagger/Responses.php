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
                        items: new OA\Items(ref: '#/components/schemas/shop-data')
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
                ref: '#/components/schemas/shop-data'
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
                        items: new OA\Items(ref: '#/components/schemas/shop-data')
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

class Responses
{
}
