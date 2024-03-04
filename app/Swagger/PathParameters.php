<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\PathParameter(
    parameter: 'user-id',
    name: 'user',
    description: 'ユーザーID',
    required: true,
    schema: new OA\Schema(
        type: 'integer',
        format: 'int64',
        example: 1,
    ),
)]

#[OA\PathParameter(
    parameter: 'customer-id',
    name: 'customer',
    description: '顧客ID',
    required: true,
    schema: new OA\Schema(
        type: 'integer',
        format: 'int64',
        example: 1,
    ),
)]

#[OA\PathParameter(
    parameter: 'shop-id',
    name: 'shop',
    description: '飲食店ID',
    required: true,
    schema: new OA\Schema(
        type: 'integer',
        format: 'int64',
        example: 1,
    ),
)]

class PathParameters
{
}
