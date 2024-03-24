<?php

declare(strict_types=1);

namespace App\Swagger;

use App\Types\FavoriteStatus;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'auth-status',
    oneOf: [
        new OA\Schema(ref: '#/components/schemas/auth-status-guest'),
        new OA\Schema(ref: '#/components/schemas/auth-status-user'),
    ],
)]

#[OA\Schema(
    schema: 'auth-status-guest',
    type: 'object',
    required: ['status'],
    properties: [
        new OA\Property(
            property: 'status',
            type: 'string',
            enum: ['guest']
        ),
    ]
)]

#[OA\Schema(
    schema: 'auth-status-user',
    type: 'object',
    required: ['status', 'id', 'has_verified_email'],
    properties: [
        new OA\Property(
            property: 'status',
            type: 'string',
            enum: ['admin', 'owner', 'customer']
        ),
        new OA\Property(
            property: 'id',
            type: 'integer',
            format: 'int64',
        ),
        new OA\Property(
            property: 'has_verified_email',
            type: 'boolean',
        ),
    ]
)]

#[OA\Schema(
    schema: 'notification-email-error',
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
                    property: 'title',
                    type: 'array',
                    items: new OA\Items(
                        type: 'string'
                    )
                ),
                new OA\Property(
                    property: 'body',
                    type: 'array',
                    items: new OA\Items(
                        type: 'string'
                    )
                ),
            ]
        ),
    ],
)]

#[OA\Schema(
    schema: 'register-error',
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
)]

#[OA\Schema(
    schema: 'login-error',
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
)]

#[OA\Schema(
    schema: 'area-data',
    description: 'エリア情報',
    type: 'object',
    required: ['id', 'name'],
    properties: [
        new OA\Property(
            property: 'id',
            description: 'エリアID',
            type: 'integer',
            format: 'int64'
        ),
        new OA\Property(
            property: 'name',
            description: 'エリア名',
            type: 'string'
        ),
    ]
)]

#[OA\Schema(
    schema: 'genre-data',
    description: 'ジャンル情報',
    type: 'object',
    required: ['id', 'name'],
    properties: [
        new OA\Property(
            property: 'id',
            description: 'ジャンルID',
            type: 'integer',
            format: 'int64'
        ),
        new OA\Property(
            property: 'name',
            description: 'ジャンル名',
            type: 'string'
        ),
    ]
)]

#[OA\Schema(
    schema: 'customer-shop-data',
    description: '顧客向け飲食店情報',
    type: 'object',
    required: [
        'id',
        'name',
        'area',
        'genre',
        'image_url',
        'detail',
        'favorite_status',
    ],
    properties: [
        new OA\Property(
            property: 'id',
            description: '飲食店ID',
            type: 'integer',
            format: 'int64'
        ),
        new OA\Property(
            property: 'name',
            description: '飲食店名',
            type: 'string'
        ),
        new OA\Property(
            property: 'area',
            ref: '#/components/schemas/area-data'
        ),
        new OA\Property(
            property: 'genre',
            ref: '#/components/schemas/genre-data'
        ),
        new OA\Property(
            property: 'image_url',
            description: '画像URL',
            type: 'string',
            format: 'uri',
        ),
        new OA\Property(
            property: 'detail',
            description: '飲食店詳細',
            type: 'string',
        ),
        new OA\Property(
            property: 'favorite_status',
            description: 'お気に入りステータス',
            type: 'string',
            enum: FavoriteStatus::class,
        ),
    ]
)]

#[OA\Schema(
    schema: 'owner-shop-data',
    description: '店舗代表者向け飲食店情報',
    type: 'object',
    required: [
        'id',
        'name',
        'area',
        'genre',
        'image_url',
        'detail',
    ],
    properties: [
        new OA\Property(
            property: 'id',
            description: '飲食店ID',
            type: 'integer',
            format: 'int64'
        ),
        new OA\Property(
            property: 'name',
            description: '飲食店名',
            type: 'string'
        ),
        new OA\Property(
            property: 'area',
            ref: '#/components/schemas/area-data'
        ),
        new OA\Property(
            property: 'genre',
            ref: '#/components/schemas/genre-data'
        ),
        new OA\Property(
            property: 'image_url',
            description: '画像URL',
            type: 'string',
            format: 'uri',
        ),
        new OA\Property(
            property: 'detail',
            description: '飲食店詳細',
            type: 'string',
        ),
    ]
)]

#[OA\Schema(
    schema: 'reservation-data',
    description: '予約情報',
    type: 'object',
    required: [
        'id',
        'shop',
        'reserved_at',
        'number_of_guests',
    ],
    properties: [
        new OA\Property(
            property: 'id',
            description: '予約ID',
            type: 'integer',
            format: 'int64'
        ),
        new OA\Property(
            property: 'shop',
            ref: '#/components/schemas/customer-shop-data'
        ),
        new OA\Property(
            property: 'reserved_at',
            description: '予約日時',
            type: 'string',
            format: 'date-time',
        ),
        new OA\Property(
            property: 'number_of_guests',
            description: '予約人数',
            type: 'integer',
            minimum: 1,
        ),
    ]
)]

#[OA\Schema(
    schema: 'reservation-error',
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
                    property: 'reserved_at',
                    type: 'array',
                    items: new OA\Items(
                        type: 'string'
                    )
                ),
                new OA\Property(
                    property: 'number_of_guests',
                    type: 'array',
                    items: new OA\Items(
                        type: 'string'
                    )
                ),
            ]
        ),
    ],
)]

#[OA\Schema(
    schema: 'create-shop-error',
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
                    property: 'area',
                    type: 'array',
                    items: new OA\Items(
                        type: 'string'
                    )
                ),
                new OA\Property(
                    property: 'genre',
                    type: 'array',
                    items: new OA\Items(
                        type: 'string'
                    )
                ),
                new OA\Property(
                    property: 'image',
                    type: 'array',
                    items: new OA\Items(
                        type: 'string'
                    )
                ),
                new OA\Property(
                    property: 'detail',
                    type: 'array',
                    items: new OA\Items(
                        type: 'string'
                    )
                ),
            ]
        ),
    ],
)]

#[OA\Schema(
    schema: 'reservation-for-owner',
    description: '店舗代表者向け飲食店別予約情報',
    type: 'object',
    required: [
        'id',
        'customer_name',
        'reserved_at',
        'number_of_guests',
    ],
    properties: [
        new OA\Property(
            property: 'id',
            description: '予約ID',
            type: 'integer',
            format: 'int64'
        ),
        new OA\Property(
            property: 'customer_name',
            description: '顧客名',
            type: 'string',
        ),
        new OA\Property(
            property: 'reserved_at',
            description: '予約日時',
            type: 'string',
            format: 'date-time',
        ),
        new OA\Property(
            property: 'number_of_guests',
            description: '予約人数',
            type: 'integer',
            minimum: 1,
        ),
    ]
)]

#[OA\Schema(
    schema: 'pagination',
    description: 'ページネーション',
    type: 'object',
    required: [
        'meta',
        'links',
    ],
    properties: [
        new OA\Property(
            property: 'meta',
            ref: '#/components/schemas/pagination-meta',
        ),
        new OA\Property(
            property: 'links',
            ref: '#/components/schemas/pagination-links',
        ),
    ]
)]

#[OA\Schema(
    schema: 'pagination-meta',
    description: 'ページネーションメタ情報',
    type: 'object',
    required: [
        'current_page',
        'from',
        'last_page',
        'links',
        'path',
        'per_page',
        'to',
        'total',
    ],
    properties: [
        new OA\Property(
            property: 'current_page',
            description: '現在のページ番号',
            type: 'integer',
            minimum: 1,
        ),
        new OA\Property(
            property: 'from',
            description: '現在のページの最初のレコード番号',
            type: 'integer',
            minimum: 1,
            nullable: true,
        ),
        new OA\Property(
            property: 'last_page',
            description: '最終ページ番号',
            type: 'integer',
            minimum: 1,
        ),
        new OA\Property(
            property: 'links',
            description: 'ページネーションリンク',
            type: 'array',
            items: new OA\Items(
                type: 'object',
                required: [
                    'url',
                    'label',
                    'active',
                ],
                properties: [
                    new OA\Property(
                        property: 'url',
                        description: 'リンクURL',
                        type: 'string',
                        format: 'uri',
                        nullable: true,
                    ),
                    new OA\Property(
                        property: 'label',
                        description: 'リンクラベル',
                        type: 'string',
                    ),
                    new OA\Property(
                        property: 'active',
                        description: 'アクティブかどうか',
                        type: 'boolean',
                    ),
                ],
            ),
        ),
        new OA\Property(
            property: 'path',
            description: '現在のページのURL',
            type: 'string',
            format: 'uri',
        ),
        new OA\Property(
            property: 'per_page',
            description: '1ページあたりの件数',
            type: 'integer',
            minimum: 1,
        ),
        new OA\Property(
            property: 'to',
            description: '現在のページの最後のレコード番号',
            type: 'integer',
            minimum: 1,
            nullable: true,
        ),
        new OA\Property(
            property: 'total',
            description: '総件数',
            type: 'integer',
            minimum: 0,
        ),
    ]
)]

#[OA\Schema(
    schema: 'pagination-links',
    description: 'ページネーションリンク',
    type: 'object',
    required: [
        'first',
        'last',
        'prev',
        'next',
    ],
    properties: [
        new OA\Property(
            property: 'first',
            description: '最初のページのURL',
            type: 'string',
            format: 'uri',
        ),
        new OA\Property(
            property: 'last',
            description: '最後のページのURL',
            type: 'string',
            format: 'uri',
        ),
        new OA\Property(
            property: 'prev',
            description: '前のページのURL',
            type: 'string',
            format: 'uri',
            nullable: true,
        ),
        new OA\Property(
            property: 'next',
            description: '次のページのURL',
            type: 'string',
            format: 'uri',
            nullable: true,
        ),
    ]
)]

class Schemas
{
}
