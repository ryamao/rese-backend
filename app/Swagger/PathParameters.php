<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\PathParameter(
    parameter: 'user-id',
    name: 'user_id',
    description: 'ユーザーID',
    required: true,
    example: 1,
)]

class PathParameters
{
}
