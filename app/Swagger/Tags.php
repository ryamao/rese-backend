<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Area',
    description: 'エリアに関するAPI'
)]

#[OA\Tag(
    name: 'Auth',
    description: '認証に関するAPI'
)]

#[OA\Tag(
    name: 'Customer',
    description: '一般会員に関するAPI'
)]

class Tags
{
}
