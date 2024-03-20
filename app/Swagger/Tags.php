<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Auth',
    description: '認証に関するAPI'
)]

#[OA\Tag(
    name: 'Area',
    description: 'エリアに関するAPI'
)]

#[OA\Tag(
    name: 'Genre',
    description: 'ジャンルに関するAPI'
)]

#[OA\Tag(
    name: 'Shop',
    description: '飲食店に関するAPI'
)]

#[OA\Tag(
    name: 'Customer',
    description: '顧客に関するAPI'
)]

#[OA\Tag(
    name: 'Favorite',
    description: 'お気に入りに関するAPI'
)]

#[OA\Tag(
    name: 'Reservation',
    description: '予約に関するAPI'
)]

#[OA\Tag(
    name: 'Admin',
    description: '管理者に関するAPI'
)]

#[OA\Tag(
    name: 'Owner',
    description: '店舗代表者に関するAPI'
)]

class Tags
{
}
