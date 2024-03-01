<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\QueryParameter(
    parameter: 'area-query',
    name: 'area',
    in: 'query',
    description: 'エリアID',
    required: false,
    schema: new OA\Schema(
        type: 'integer',
        format: 'int64',
        example: 1,
    ),
)]

#[OA\QueryParameter(
    parameter: 'genre-query',
    name: 'genre',
    in: 'query',
    description: 'ジャンルID',
    required: false,
    schema: new OA\Schema(
        type: 'integer',
        format: 'int64',
        example: 1,
    ),
)]

#[OA\QueryParameter(
    parameter: 'search-query',
    name: 'search',
    in: 'query',
    description: '店名検索キーワード',
    required: false,
    schema: new OA\Schema(
        type: 'string',
        example: '屋',
    ),
)]

class QueryParameters
{
}
