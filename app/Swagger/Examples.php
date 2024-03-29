<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Examples(
    example: 'get-auth-status-200-guest',
    summary: '未認証の状態',
    value: [
        'status' => 'guest',
    ]
)]

#[OA\Examples(
    example: 'get-auth-status-200-customer-unverified',
    summary: '顧客として認証済みだが、メールアドレスが未確認の状態',
    value: [
        'status' => 'customer',
        'id' => 1,
        'has_verified_email' => false,
    ]
)]

#[OA\Examples(
    example: 'get-auth-status-200-customer-verified',
    summary: '顧客として認証済みで、メールアドレスも確認済みの状態',
    value: [
        'status' => 'customer',
        'id' => 1,
        'has_verified_email' => true,
    ]
)]

#[OA\Examples(
    example: 'post-notification-email-422-required',
    summary: 'タイトル、本文が入力されていない場合',
    value: [
        'message' => 'タイトルを入力してください (and 1 more error)',
        'errors' => [
            'title' => ['タイトルを入力してください'],
            'body' => ['本文を入力してください'],
        ],
    ]
)]

#[OA\Examples(
    example: 'post-auth-register-422-required',
    summary: '名前、メールアドレス、パスワードが入力されていない場合',
    value: [
        'message' => '名前を入力してください (and 2 more errors)',
        'errors' => [
            'name' => ['名前を入力してください'],
            'email' => ['メールアドレスを入力してください'],
            'password' => ['パスワードを入力してください'],
        ],
    ]
)]

#[OA\Examples(
    example: 'post-auth-register-422-email',
    summary: 'メールアドレスが正しい形式でない場合',
    value: [
        'message' => 'メールアドレスを正しい形式で入力してください',
        'errors' => [
            'email' => ['メールアドレスを正しい形式で入力してください'],
        ],
    ]
)]

#[OA\Examples(
    example: 'post-auth-register-422-password',
    summary: 'パスワードが8文字未満の場合',
    value: [
        'message' => 'パスワードは8文字以上で入力してください',
        'errors' => [
            'password' => ['パスワードは8文字以上で入力してください'],
        ],
    ]
)]

#[OA\Examples(
    example: 'post-auth-login-422-required',
    summary: 'メールアドレス、パスワードが入力されていない場合',
    value: [
        'message' => 'メールアドレスを入力してください (and 1 more error)',
        'errors' => [
            'email' => ['メールアドレスを入力してください'],
            'password' => ['パスワードを入力してください'],
        ],
    ]
)]

#[OA\Examples(
    example: 'post-auth-login-422-email',
    summary: '顧客が登録されていない場合',
    value: [
        'message' => '認証情報が登録されていません',
        'errors' => [
            'email' => ['認証情報が登録されていません'],
        ],
    ]
)]

#[OA\Examples(
    example: 'get-areas-200',
    summary: 'エリア一覧の例',
    value: [
        'areas' => [
            ['id' => 1, 'name' => '東京'],
            ['id' => 2, 'name' => '大阪'],
            ['id' => 3, 'name' => '福岡'],
        ],
    ]
)]

#[OA\Examples(
    example: 'get-genres-200',
    summary: 'ジャンル一覧の例',
    value: [
        'genres' => [
            ['id' => 1, 'name' => '和食'],
            ['id' => 2, 'name' => '中華'],
            ['id' => 3, 'name' => 'イタリアン'],
        ],
    ]
)]

#[OA\Examples(
    example: 'get-shops-200-first-page',
    summary: '1ページ目の飲食店一覧',
    value: [
        'meta' => [
            'current_page' => 1,
            'from' => 1,
            'last_page' => 3,
            'path' => 'https://api.rese.com/shops',
            'per_page' => 5,
            'to' => 5,
            'total' => 12,
        ],
        'links' => [
            ['url' => null, 'label' => '&laquo; Previous', 'active' => false],
            ['url' => 'https://api.rese.com/shops?page=1', 'label' => '1', 'active' => true],
            ['url' => 'https://api.rese.com/shops?page=2', 'label' => '2', 'active' => true],
            ['url' => 'https://api.rese.com/shops?page=3', 'label' => '3', 'active' => true],
            ['url' => 'https://api.rese.com/shops?page=2', 'label' => 'Next &raquo;', 'active' => true],
        ],
        'data' => [
            ['id' => 1, 'name' => '店舗1', 'area' => ['id' => 1, 'name' => '東京都'], 'genre' => ['id' => 1, 'name' => '和食'], 'image_url' => 'https://api.rese.com/images/1.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'marked'],
            ['id' => 2, 'name' => '店舗2', 'area' => ['id' => 2, 'name' => '大阪府'], 'genre' => ['id' => 2, 'name' => '中華'], 'image_url' => 'https://api.rese.com/images/2.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'unmarked'],
            ['id' => 3, 'name' => '店舗3', 'area' => ['id' => 3, 'name' => '福岡県'], 'genre' => ['id' => 3, 'name' => 'イタリアン'], 'image_url' => 'https://api.rese.com/images/3.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'unknown'],
            ['id' => 4, 'name' => '店舗4', 'area' => ['id' => 1, 'name' => '東京都'], 'genre' => ['id' => 1, 'name' => '和食'], 'image_url' => 'https://api.rese.com/images/4.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'marked'],
            ['id' => 5, 'name' => '店舗5', 'area' => ['id' => 2, 'name' => '大阪府'], 'genre' => ['id' => 2, 'name' => '中華'], 'image_url' => 'https://api.rese.com/images/5.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'unmarked'],
        ],
    ]
)]

#[OA\Examples(
    example: 'get-shops-200-middle-page',
    summary: '2ページ目の飲食店一覧',
    value: [
        'meta' => [
            'current_page' => 2,
            'from' => 6,
            'last_page' => 3,
            'path' => 'https://api.rese.com/shops',
            'per_page' => 5,
            'to' => 10,
            'total' => 12,
        ],
        'links' => [
            ['url' => 'https://api.rese.com/shops?page=1', 'label' => '&laquo; Previous', 'active' => true],
            ['url' => 'https://api.rese.com/shops?page=1', 'label' => '1', 'active' => true],
            ['url' => 'https://api.rese.com/shops?page=2', 'label' => '2', 'active' => true],
            ['url' => 'https://api.rese.com/shops?page=3', 'label' => '3', 'active' => true],
            ['url' => 'https://api.rese.com/shops?page=3', 'label' => 'Next &raquo;', 'active' => true],
        ],
        'data' => [
            ['id' => 6, 'name' => '店舗6', 'area' => ['id' => 1, 'name' => '東京都'], 'genre' => ['id' => 1, 'name' => '和食'], 'image_url' => 'https://api.rese.com/images/6.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'marked'],
            ['id' => 7, 'name' => '店舗7', 'area' => ['id' => 2, 'name' => '大阪府'], 'genre' => ['id' => 2, 'name' => '中華'], 'image_url' => 'https://api.rese.com/images/7.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'unmarked'],
            ['id' => 8, 'name' => '店舗8', 'area' => ['id' => 3, 'name' => '福岡県'], 'genre' => ['id' => 3, 'name' => 'イタリアン'], 'image_url' => 'https://api.rese.com/images/8.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'unknown'],
            ['id' => 9, 'name' => '店舗9', 'area' => ['id' => 1, 'name' => '東京都'], 'genre' => ['id' => 1, 'name' => '和食'], 'image_url' => 'https://api.rese.com/images/9.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'marked'],
            ['id' => 10, 'name' => '店舗10', 'area' => ['id' => 2, 'name' => '大阪府'], 'genre' => ['id' => 2, 'name' => '中華'], 'image_url' => 'https://api.rese.com/images/10.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'unmarked'],
        ],
    ]
)]

#[OA\Examples(
    example: 'get-shops-200-last-page',
    summary: '3ページ目の飲食店一覧',
    value: [
        'meta' => [
            'current_page' => 3,
            'from' => 11,
            'last_page' => 3,
            'path' => 'https://api.rese.com/shops',
            'per_page' => 5,
            'to' => 12,
            'total' => 12,
        ],
        'links' => [
            ['url' => 'https://api.rese.com/shops?page=2', 'label' => '&laquo; Previous', 'active' => true],
            ['url' => 'https://api.rese.com/shops?page=1', 'label' => '1', 'active' => true],
            ['url' => 'https://api.rese.com/shops?page=2', 'label' => '2', 'active' => true],
            ['url' => 'https://api.rese.com/shops?page=3', 'label' => '3', 'active' => true],
            ['url' => null, 'label' => 'Next &raquo;', 'active' => false],
        ],
        'data' => [
            ['id' => 11, 'name' => '店舗11', 'area' => ['id' => 1, 'name' => '東京都'], 'genre' => ['id' => 1, 'name' => '和食'], 'image_url' => 'https://api.rese.com/images/11.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'marked'],
            ['id' => 12, 'name' => '店舗12', 'area' => ['id' => 2, 'name' => '大阪府'], 'genre' => ['id' => 2, 'name' => '中華'], 'image_url' => 'https://api.rese.com/images/12.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'unmarked'],
        ],
    ]
)]

#[OA\Examples(
    example: 'get-shops-200-empty',
    summary: '該当する飲食店がない場合',
    value: [
        'meta' => [
            'current_page' => 1,
            'from' => null,
            'last_page' => 1,
            'path' => 'https://api.rese.com/shops',
            'per_page' => 10,
            'to' => null,
            'total' => 0,
        ],
        'links' => [
            ['url' => null, 'label' => '&laquo; Previous', 'active' => false],
            ['url' => 'https://api.rese.com/shops?page=1', 'label' => '1', 'active' => false],
            ['url' => null, 'label' => 'Next &raquo;', 'active' => false],
        ],
        'data' => [],
    ]
)]

#[OA\Examples(
    example: 'get-shop-200',
    summary: '飲食店情報の例',
    value: [
        'data' => [
            'id' => 1,
            'name' => '店舗1',
            'area' => ['id' => 1, 'name' => '東京都'],
            'genre' => ['id' => 1, 'name' => '和食'],
            'image_url' => 'https://api.rese.com/images/1.jpg',
            'detail' => 'サンプルテキスト',
            'favorite_status' => 'marked',
        ],
    ]
)]

#[OA\Examples(
    example: 'get-customer-favorites-200',
    summary: 'お気に入り一覧の例',
    value: [
        'meta' => [
            'current_page' => 1,
            'from' => 1,
            'last_page' => 1,
            'path' => 'https://api.rese.com/customers/1/favorites',
            'per_page' => 5,
            'to' => 2,
            'total' => 2,
        ],
        'links' => [
            ['url' => null, 'label' => '&laquo; Previous', 'active' => false],
            ['url' => 'https://api.rese.com/shops?page=1', 'label' => '1', 'active' => false],
            ['url' => null, 'label' => 'Next &raquo;', 'active' => false],
        ],
        'data' => [
            ['id' => 1, 'name' => '店舗1', 'area' => ['id' => 1, 'name' => '東京都'], 'genre' => ['id' => 1, 'name' => '和食'], 'image_url' => 'https://api.rese.com/images/1.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'marked'],
            ['id' => 2, 'name' => '店舗2', 'area' => ['id' => 2, 'name' => '大阪府'], 'genre' => ['id' => 2, 'name' => '中華'], 'image_url' => 'https://api.rese.com/images/2.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'marked'],
        ],
    ]
)]

#[OA\Examples(
    example: 'get-customer-shop-reservations-200-example',
    summary: '予約一覧の例',
    value: [
        'reservations' => [
            ['id' => 1, 'shop' => ['id' => 1, 'name' => '店舗1', 'area' => ['id' => 1, 'name' => '東京都'], 'genre' => ['id' => 1, 'name' => '和食'], 'image_url' => 'https://api.rese.com/images/1.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'unmarked'], 'reserved_at' => '2021-12-31T18:00:00+09:00', 'number_of_guests' => 2],
            ['id' => 2, 'shop' => ['id' => 2, 'name' => '店舗2', 'area' => ['id' => 2, 'name' => '大阪府'], 'genre' => ['id' => 2, 'name' => '中華'], 'image_url' => 'https://api.rese.com/images/2.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'marked'], 'reserved_at' => '2022-01-01T19:00:00+09:00', 'number_of_guests' => 4],
        ],
    ]
)]

#[OA\Examples(
    example: 'get-customer-shop-reservations-200-empty',
    summary: '該当する予約がない場合',
    value: [
        'reservations' => [],
    ]
)]

#[OA\Examples(
    example: 'post-customer-shop-reservations-201',
    summary: '予約追加成功',
    value: [
        'id' => 1,
        'shop' => ['id' => 1, 'name' => '店舗1', 'area' => ['id' => 1, 'name' => '東京都'], 'genre' => ['id' => 1, 'name' => '和食'], 'image_url' => 'https://api.rese.com/images/1.jpg', 'detail' => 'サンプルテキスト', 'favorite_status' => 'marked'],
        'reserved_at' => '2022-01-01T19:00:00+09:00',
        'number_of_guests' => 4,
    ]
)]

#[OA\Examples(
    example: 'post-customer-shop-reservations-422-required',
    summary: '予約日時、人数が入力されていない場合',
    value: [
        'message' => '予約日時を入力してください (and 1 more error)',
        'errors' => [
            'reserved_at' => ['予約日時を入力してください'],
            'number_of_guests' => ['人数を入力してください'],
        ],
    ]
)]

#[OA\Examples(
    example: 'post-customer-shop-reservations-422-reserved_at',
    summary: '予約日時がRFC3339形式でない場合',
    value: [
        'message' => '予約日時はRFC3339形式で入力してください',
        'errors' => [
            'reserved_at' => ['予約日時はRFC3339形式で入力してください'],
        ],
    ]
)]

#[OA\Examples(
    example: 'post-customer-shop-reservations-422-past',
    summary: '過去の日時を指定した場合',
    value: [
        'message' => '過去の日時は指定できません',
        'errors' => [
            'reserved_at' => ['過去の日時は指定できません'],
        ],
    ]
)]

#[OA\Examples(
    example: 'post-customer-shop-reservations-422-number_of_guests',
    summary: '人数が0以下の場合',
    value: [
        'message' => '人数は1以上で入力してください',
        'errors' => [
            'number_of_guests' => ['人数は1以上で入力してください'],
        ],
    ]
)]

#[OA\Examples(
    example: 'post-owner-shops-422-required',
    summary: '店舗名、エリア、ジャンル、画像、詳細が入力されていない場合',
    value: [
        'message' => '店舗名を入力してください (and 4 more errors)',
        'errors' => [
            'name' => ['店舗名を入力してください'],
            'area' => ['エリアを選択してください'],
            'genre' => ['ジャンルを選択してください'],
            'image' => ['画像を選択してください'],
            'detail' => ['詳細を入力してください'],
        ],
    ]
)]

class Examples
{
}
