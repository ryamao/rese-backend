<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Rese',
    version: '0.0.1',
    description: 'Rese API',
)]

#[OA\Server(
    url: 'http://rese-backend.test',
    description: 'Local server (Herd)',
)]
#[OA\Server(
    url: 'http://localhost:8000',
    description: 'Local server (php artisan serve)',
)]

class Meta
{
}
