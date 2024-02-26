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

class PathParameters
{
}
