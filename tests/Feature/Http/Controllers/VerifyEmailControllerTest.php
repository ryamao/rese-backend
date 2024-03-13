<?php

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Spectator\Spectator;

describe('GET /email/verify/{id}/{hash}', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');

        $this->user = User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $this->user->getKey(),
                'hash' => sha1($this->user->getEmailForVerification()),
            ]
        );
    });

    test('メールアドレスの確認が完了する', function () {
        $this->actingAs($this->user)
            ->get($this->url)
            ->assertValidRequest()
            ->assertValidResponse(302)
            ->assertRedirect(env('SPA_URL').'/thanks?verified=1');

        $this->assertTrue($this->user->hasVerifiedEmail());
    });

    test('認証済みのユーザーは確認できない', function () {
        $this->user->markEmailAsVerified();

        $this->actingAs($this->user)
            ->get($this->url)
            ->assertValidRequest()
            ->assertValidResponse(302)
            ->assertRedirect(env('SPA_URL').'/thanks?verified=1');

        $this->assertTrue($this->user->hasVerifiedEmail());
    });

    test('ゲスト状態では確認できない', function () {
        $this->getJson($this->url)
            ->assertValidRequest()
            ->assertValidResponse(401);

        $this->assertFalse($this->user->hasVerifiedEmail());
    });

    test('URLの有効期限が切れている場合は確認できない', function () {
        $this->url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->subMinutes(1),
            [
                'id' => $this->user->getKey(),
                'hash' => sha1($this->user->getEmailForVerification()),
            ]
        );

        $this->actingAs($this->user)
            ->getJson($this->url)
            ->assertValidRequest()
            ->assertValidResponse(403);

        $this->assertFalse($this->user->hasVerifiedEmail());
    });

    test('別のユーザーのメールアドレスは確認できない', function () {
        $anotherUser = User::create([
            'name' => 'another',
            'email' => 'abc@example.com',
            'password' => 'password',
        ]);

        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $anotherUser->getKey(),
                'hash' => sha1($anotherUser->getEmailForVerification()),
            ]
        );

        $this->actingAs($this->user)
            ->getJson($url)
            ->assertValidRequest()
            ->assertValidResponse(403);

        $this->assertFalse($anotherUser->hasVerifiedEmail());
    });

    test('URLが不正な場合は確認できない', function () {
        $this->actingAs($this->user)
            ->getJson('/email/verify/invalid/invalid')
            ->assertValidRequest()
            ->assertValidResponse(404);

        $this->assertFalse($this->user->hasVerifiedEmail());
    });
});
