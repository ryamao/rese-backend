<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: 'post-owners',
    description: '店舗代表者追加リクエスト',
    required: true,
    content: new OA\JsonContent(
        required: ['name', 'email', 'password'],
        properties: [
            new OA\Property(
                property: 'name',
                description: '店舗代表者名',
                type: 'string',
                minLength: 1,
                maxLength: 100,
                example: 'テストオーナー',
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
    request: 'post-notification-email',
    description: 'お知らせメール送信リクエスト',
    required: true,
    content: new OA\JsonContent(
        required: ['title', 'body'],
        properties: [
            new OA\Property(
                property: 'title',
                description: 'タイトル',
                type: 'string',
                minLength: 1,
                maxLength: 100,
                example: 'タイトル',
            ),
            new OA\Property(
                property: 'body',
                description: '本文',
                type: 'string',
                minLength: 1,
                example: '本文',
            ),
        ]
    )
)]

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

#[OA\RequestBody(
    request: 'put-customer-reservation',
    description: '予約変更リクエスト',
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

#[OA\RequestBody(
    request: 'post-owner-shops',
    description: '店舗代表者別店舗登録リクエスト',
    required: true,
    content: new OA\MediaType(
        mediaType: 'multipart/form-data',
        schema: new OA\Schema(
            type: 'object',
            required: ['name', 'area', 'genre', 'image', 'detail'],
            properties: [
                new OA\Property(
                    property: 'name',
                    description: '店舗名',
                    type: 'string',
                    minLength: 1,
                    maxLength: 100,
                    example: 'テスト店舗',
                ),
                new OA\Property(
                    property: 'area',
                    description: 'エリア',
                    type: 'string',
                    minLength: 1,
                    maxLength: 100,
                    example: 'テストエリア',
                ),
                new OA\Property(
                    property: 'genre',
                    description: 'ジャンル',
                    type: 'string',
                    minLength: 1,
                    maxLength: 100,
                    example: 'テストジャンル',
                ),
                new OA\Property(
                    property: 'image',
                    description: '画像',
                    type: 'string',
                    format: 'binary',
                ),
                new OA\Property(
                    property: 'detail',
                    description: '詳細',
                    type: 'string',
                    minLength: 1,
                    example: 'テスト詳細',
                ),
            ]
        ),
        encoding: [
            'image' => [
                'contentType' => 'image/*',
            ],
        ]
    )
)]

#[OA\RequestBody(
    request: 'put-owner-shop',
    description: '店舗代表者別店舗更新リクエスト',
    required: true,
    content: new OA\MediaType(
        mediaType: 'multipart/form-data',
        schema: new OA\Schema(
            type: 'object',
            required: ['name', 'area', 'genre', 'detail'],
            properties: [
                new OA\Property(
                    property: 'name',
                    description: '店舗名',
                    type: 'string',
                    minLength: 1,
                    maxLength: 100,
                    example: 'テスト店舗',
                ),
                new OA\Property(
                    property: 'area',
                    description: 'エリア',
                    type: 'string',
                    minLength: 1,
                    maxLength: 100,
                    example: 'テストエリア',
                ),
                new OA\Property(
                    property: 'genre',
                    description: 'ジャンル',
                    type: 'string',
                    minLength: 1,
                    maxLength: 100,
                    example: 'テストジャンル',
                ),
                new OA\Property(
                    property: 'image',
                    description: '画像',
                    type: 'string',
                    format: 'binary',
                ),
                new OA\Property(
                    property: 'detail',
                    description: '詳細',
                    type: 'string',
                    minLength: 1,
                    example: 'テスト詳細',
                ),
            ]
        ),
        encoding: [
            'image' => [
                'contentType' => 'image/*',
            ],
        ]
    )
)]

#[OA\RequestBody(
    request: 'post-shop-reviews',
    description: 'レビュー投稿リクエスト',
    required: true,
    content: new OA\JsonContent(
        required: ['rating'],
        properties: [
            new OA\Property(
                property: 'rating',
                description: '評価',
                type: 'integer',
                minimum: 1,
                maximum: 5,
                example: 5,
            ),
            new OA\Property(
                property: 'comment',
                description: 'コメント',
                type: 'string',
                nullable: true,
                example: 'テストコメント',
            ),
        ]
    )
)]

class RequestBodies
{
}
