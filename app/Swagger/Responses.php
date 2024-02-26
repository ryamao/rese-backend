<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Response(
    response: 'ok',
    description: 'リクエストが成功しリソースが見つかった',
)]

#[OA\Response(
    response: 'created',
    description: 'リクエストが成功しリソースが作成された',
)]

#[OA\Response(
    response: 'found',
    description: 'リクエストが成功しリソースが見つかった',
)]

#[OA\Response(
    response: 'unauthorized',
    description: '認証エラー',
)]

#[OA\Response(
    response: 'forbidden',
    description: '認可エラー',
)]

#[OA\Response(
    response: 'not-found',
    description: '指定されたリソースが存在しない',
)]

#[OA\Response(
    response: 'unprocessable-entity',
    description: 'リクエストが正しくない',
)]

class Responses
{
}
