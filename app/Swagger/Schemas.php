<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'pagination',
    description: 'ページネーション',
    type: 'object',
    required: [
        'meta',
        'links',
        'data',
    ],
    properties: [
        new OA\Property(
            property: 'meta',
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
                    oneOf: [
                        new OA\Schema(type: 'null'),
                        new OA\Schema(type: 'integer', minimum: 1),
                    ],
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
                                oneOf: [
                                    new OA\Schema(type: 'null'),
                                    new OA\Schema(type: 'string', format: 'uri'),
                                ],
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
                    oneOf: [
                        new OA\Schema(type: 'null'),
                        new OA\Schema(type: 'integer', minimum: 1),
                    ],
                ),
                new OA\Property(
                    property: 'total',
                    description: '総件数',
                    type: 'integer',
                    minimum: 0,
                ),
            ]
        ),
        new OA\Property(
            property: 'links',
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
                    oneOf: [
                        new OA\Schema(type: 'null'),
                        new OA\Schema(type: 'string', format: 'uri'),
                    ],
                ),
                new OA\Property(
                    property: 'next',
                    description: '次のページのURL',
                    oneOf: [
                        new OA\Schema(type: 'null'),
                        new OA\Schema(type: 'string', format: 'uri'),
                    ],
                ),
            ]
        ),
        new OA\Property(
            property: 'data',
            description: 'ページネーション結果',
            type: 'array',
            items: new OA\Items(),
        ),
    ]
)]

class Schemas
{
}
