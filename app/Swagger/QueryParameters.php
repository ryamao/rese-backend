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
    ),
)]

#[OA\QueryParameter(
    parameter: 'page-query',
    name: 'page',
    in: 'query',
    description: 'ページ番号',
    required: false,
    schema: new OA\Schema(
        type: 'integer',
        format: 'int32',
    ),
)]

#[OA\QueryParameter(
    parameter: 'signature-query',
    name: 'signature',
    in: 'query',
    description: '署名',
    required: true,
    schema: new OA\Schema(
        type: 'string',
    ),
)]

#[OA\QueryParameter(
    parameter: 'expires-query',
    name: 'expires',
    in: 'query',
    description: '有効期限',
    required: false,
    schema: new OA\Schema(
        type: 'integer',
        format: 'int64',
    ),
)]

class QueryParameters
{
}
