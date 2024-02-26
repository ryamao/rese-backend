<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spectator\Spectator;

describe('AuthenticatedSessionController', function () {
    describe('POST /auth/login', function () {
        $requestBody = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        test('ログイン成功', function () use ($requestBody) {
            Spectator::using('api-docs.json');

            User::factory()->create([
                'email' => $requestBody['email'],
                'password' => Hash::make($requestBody['password']),
            ]);

            $this->postJson('/auth/login', $requestBody)
                ->assertValidRequest()
                ->assertValidResponse(200);
        });

        test('認証済みユーザーがログインを行う', function () use ($requestBody) {
            Spectator::using('api-docs.json');

            $user = User::factory()->create();

            $this->actingAs($user)
                ->postJson('/auth/login', $requestBody)
                ->assertValidRequest()
                ->assertValidResponse(204);
        });

        test('バリデーションエラー', function (string ...$testData) {
            Spectator::using('api-docs.json');

            $this->postJson('/auth/login', $testData)
                ->assertValidRequest()
                ->assertValidResponse(422);
        })
            ->with([
                'email is empty' => array_merge($requestBody, ['email' => '']),
                'password is empty' => array_merge($requestBody, ['password' => '']),
            ]);
    });
});
