<?php

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Spectator\Spectator;

describe('POST /auth/email/verification-notification', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');
        Notification::fake();
    });

    test('セッション中のユーザーのメールアドレスに確認メールを送信する', function () {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->actingAs($user)
            ->postJson('/auth/email/verification-notification')
            ->assertValidRequest()
            ->assertValidResponse(202);

        Notification::assertSentTo(
            $user,
            Illuminate\Auth\Notifications\VerifyEmail::class
        );
    });

    test('認証済みのユーザーには確認メールを送信しない', function () {
        $user = User::factory()->create();

        $this->assertTrue($user->hasVerifiedEmail());

        $this->actingAs($user)
            ->postJson('/auth/email/verification-notification')
            ->assertValidRequest()
            ->assertValidResponse(204);

        Notification::assertNothingSent();
    });

    test('ゲスト状態では確認メールを送信できない', function () {
        $this->postJson('/auth/email/verification-notification')
            ->assertValidRequest()
            ->assertValidResponse(401);

        Notification::assertNothingSent();
    });
});
