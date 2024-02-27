<?php

declare(strict_types=1);

namespace App\Http\Responses;

use OpenApi\Attributes as OA;

#[OA\Response(
    response: 'show-customer-200',
    description: 'OK',
    content: [
        new OA\JsonContent(
            required: ['name'],
            properties: [
                new OA\Property(
                    property: 'name',
                    type: 'string',
                    example: 'テストユーザー'
                ),
            ]
        ),
    ],
)]

class ShowCustomerResponse
{
}
