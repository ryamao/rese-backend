<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class NotificationEmailController extends Controller
{
    #[OA\Post(
        operationId: 'post-notification-email',
        path: '/notification-email',
        tags: ['Admin'],
        summary: 'お知らせメール送信',
        description: 'お知らせメールをすべての顧客に対して送信する',
    )]
    #[OA\RequestBody(ref: '#/components/requestBodies/post-notification-email')]
    #[OA\Response(response: 201, ref: '#/components/responses/created')]
    #[OA\Response(response: 401, ref: '#/components/responses/unauthorized')]
    #[OA\Response(response: 403, ref: '#/components/responses/forbidden')]
    #[OA\Response(response: 422, ref: '#/components/responses/post-notification-email-422')]
    public function store(): JsonResponse
    {
        throw new \Exception('Not implemented');
    }
}
