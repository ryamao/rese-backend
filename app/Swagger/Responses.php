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
    response: 'no-content',
    description: 'リクエストが成功しリソースが存在しない',
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
    response: 'conflict',
    description: 'リクエストが競合している',
)]

#[OA\Response(
    response: 'unprocessable-entity',
    description: 'リクエストが正しくない',
)]

#[OA\Response(
    response: 'post-auth-register-422',
    description: 'バリデーションエラーまたはメールアドレスが登録済み',
    content: new OA\JsonContent(
        properties: [
            new OA\Property(
                property: 'message',
                type: 'string'
            ),
            new OA\Property(
                property: 'errors',
                type: 'array',
                items: new OA\Items(
                    properties: [
                        new OA\Property(
                            property: 'name',
                            type: 'array',
                            items: new OA\Items(
                                type: 'string'
                            )
                        ),
                        new OA\Property(
                            property: 'email',
                            type: 'array',
                            items: new OA\Items(
                                type: 'string'
                            )
                        ),
                        new OA\Property(
                            property: 'password',
                            type: 'array',
                            items: new OA\Items(
                                type: 'string'
                            )
                        )
                    ]
                )
            )
        ],
        examples: [
            "required" => new OA\Examples(
                example: "post-auth-register-422-required",
                summary: "名前、メールアドレス、パスワードが入力されていない場合",
                value: [
                    'message' => '名前を入力してください (and 2 more errors)',
                    'errors' => [
                        'name' => ['名前を入力してください'],
                        'email' => ['メールアドレスを入力してください'],
                        'password' => ['パスワードを入力してください'],
                    ]
                ]
            ),
            "email" => new OA\Examples(
                example: "post-auth-register-422-email",
                summary: "メールアドレスが正しい形式でない場合",
                value: [
                    'message' => 'メールアドレスを正しい形式で入力してください',
                    'errors' => [
                        'email' => ['メールアドレスを正しい形式で入力してください'],
                    ]
                ]
            ),
            "password" => new OA\Examples(
                example: "post-auth-register-422-password",
                summary: "パスワードが8文字未満の場合",
                value: [
                    'message' => 'パスワードは8文字以上で入力してください',
                    'errors' => [
                        'password' => ['パスワードは8文字以上で入力してください'],
                    ]
                ]
            ),
        ]
    )
)]

#[OA\Response(
    response: 'post-auth-login-422',
    description: 'バリデーションエラーまたは未登録',
    content: new OA\JsonContent(
        properties: [
            new OA\Property(
                property: 'message',
                type: 'string'
            ),
            new OA\Property(
                property: 'errors',
                type: 'array',
                items: new OA\Items(
                    properties: [
                        new OA\Property(
                            property: 'email',
                            type: 'array',
                            items: new OA\Items(
                                type: 'string'
                            )
                        ),
                        new OA\Property(
                            property: 'password',
                            type: 'array',
                            items: new OA\Items(
                                type: 'string'
                            )
                        )
                    ]
                )
            )
        ],
        examples: [
            "required" => new OA\Examples(
                example: "post-auth-login-422-required",
                summary: "メールアドレス、パスワードが入力されていない場合",
                value: [
                    'message' => 'メールアドレスを入力してください (and 1 more error)',
                    'errors' => [
                        'email' => ['メールアドレスを入力してください'],
                        'password' => ['パスワードを入力してください'],
                    ]
                ]
            ),
            "email" => new OA\Examples(
                example: "post-auth-login-422-email",
                summary: "ユーザーが登録されていない場合",
                value: [
                    'message' => '認証情報が登録されていません',
                    'errors' => [
                        'email' => ['認証情報が登録されていません'],
                    ]
                ]
            ),
        ]
    )
)]

class Responses
{
}
