<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'pagination',
    description: 'ページネーション',
    type: 'object',
    required: [
        'total',
        'per_page',
        'current_page',
        'last_page',
        'first_page_url',
        'last_page_url',
        'next_page_url',
        'prev_page_url',
        'path',
        'from',
        'to',
        'data',
    ],
    properties: [
        new OA\Property(
            property: 'total',
            description: '総件数',
            type: 'integer',
            minimum: 0,
            example: 100,
        ),
        new OA\Property(
            property: 'per_page',
            description: '1ページあたりの件数',
            type: 'integer',
            minimum: 1,
            example: 10,
        ),
        new OA\Property(
            property: 'current_page',
            description: '現在のページ番号',
            type: 'integer',
            minimum: 1,
            example: 1,
        ),
        new OA\Property(
            property: 'last_page',
            description: '最終ページ番号',
            type: 'integer',
            minimum: 1,
            example: 10,
        ),
        new OA\Property(
            property: 'first_page_url',
            description: '最初のページのURL',
            type: 'string',
            format: 'uri',
            example: 'https://rese.com/shops?page=1',
        ),
        new OA\Property(
            property: 'last_page_url',
            description: '最後のページのURL',
            type: 'string',
            format: 'uri',
            example: 'https://rese.com/shops?page=10',
        ),
        new OA\Property(
            property: 'next_page_url',
            description: '次のページのURL',
            type: 'string',
            format: 'uri',
            example: 'https://rese.com/shops?page=2',
        ),
        new OA\Property(
            property: 'prev_page_url',
            description: '前のページのURL',
            type: 'string',
            format: 'uri',
            example: 'https://rese.com/shops?page=1',
        ),
        new OA\Property(
            property: 'path',
            description: '現在のページのURL',
            type: 'string',
            format: 'uri',
            example: 'https://rese.com/shops',
        ),
        new OA\Property(
            property: 'from',
            description: '現在のページの最初のレコード番号',
            type: 'integer',
            minimum: 1,
            example: 1,
        ),
        new OA\Property(
            property: 'to',
            description: '現在のページの最後のレコード番号',
            type: 'integer',
            minimum: 1,
            example: 10,
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
