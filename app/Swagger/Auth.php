<?php

declare(strict_types=1);

namespace App\Swagger;

use OpenApi\Attributes as OA;

/**
 * Fortifyの認証機能に関するAPIを定義するクラス
 */
class Auth
{
    #[OA\Get(
        operationId: 'get-sanctum-csrf-cookie',
        path: '/sanctum/csrf-cookie',
        tags: ['Auth'],
        summary: 'CSRFトークン取得',
        description: 'CSRFトークンを取得する',
    )]
    #[OA\Response(
        response: 204,
        ref: '#/components/responses/get-sanctum-csrf-cookie-204',
    )]
    public function sanctumCsrfCookie(): void
    {
    }

    #[OA\Post(
        operationId: 'post-auth-register',
        path: '/auth/register',
        tags: ['Auth'],
        summary: '顧客登録',
        description: '顧客を新規登録する',
    )]
    #[OA\RequestBody(
        ref: '#/components/requestBodies/post-auth-register'
    )]
    #[OA\Response(
        response: 201,
        ref: '#/components/responses/created',
    )]
    #[OA\Response(
        response: 204,
        ref: '#/components/responses/no-content',
    )]
    #[OA\Response(
        response: 422,
        ref: '#/components/responses/post-auth-register-422',
    )]
    public function register(): void
    {
    }

    #[OA\Post(
        operationId: 'post-auth-login',
        path: '/auth/login',
        tags: ['Auth'],
        summary: 'ログイン',
        description: '顧客のログイン処理を行う',
    )]
    #[OA\RequestBody(
        ref: '#/components/requestBodies/post-auth-login'
    )]
    #[OA\Response(
        response: 200,
        ref: '#/components/responses/ok',
    )]
    #[OA\Response(
        response: 204,
        ref: '#/components/responses/no-content',
    )]
    #[OA\Response(
        response: 422,
        ref: '#/components/responses/post-auth-login-422',
    )]
    public function login(): void
    {
    }

    #[OA\Post(
        operationId: 'post-auth-logout',
        path: '/auth/logout',
        tags: ['Auth'],
        summary: 'ログアウト',
        description: '顧客のログアウト処理を行う',
    )]
    #[OA\Response(
        response: 204,
        ref: '#/components/responses/no-content',
    )]
    public function logout(): void
    {
    }
}
