<?php

use App\Models\User;
use Spectator\Spectator;

describe('RegisteredUserController', function () {
    $requestBody = [
        'name' => 'テストユーザー',
        'email' => 'test@example.com',
        'password' => 'password',
    ];

    test('会員登録に成功する', function () use ($requestBody) {
        Spectator::using('api-docs.json');

        $this->postJson('/auth/register', $requestBody)
            ->assertValidRequest()
            ->assertValidResponse(201);
    });

    test('認証済みが会員登録を行う', function () use ($requestBody) {
        Spectator::using('api-docs.json');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson('/auth/register', $requestBody)
            ->assertValidRequest()
            ->assertValidResponse(204);
    });

    test('バリデーションエラー', function (string ...$testData) {
        Spectator::using('api-docs.json');

        $this->postJson('/auth/register', $testData)
            ->assertValidRequest()
            ->assertValidResponse(422);
    })
        ->with([
            'name is empty' => array_merge($requestBody, ['name' => '']),
            'email is empty' => array_merge($requestBody, ['email' => '']),
            'password is empty' => array_merge($requestBody, ['password' => '']),
            'name is too long' => array_merge($requestBody, ['name' => str_repeat('a', 101)]),
            'email is invalid' => array_merge($requestBody, ['email' => 'test']),
            'email is too long' => array_merge($requestBody, ['email' => str_repeat('a', 50).'@'.str_repeat('b', 50 - 4).'.com']),
            'password is too short' => array_merge($requestBody, ['password' => 'pass']),
            'password is too long' => array_merge($requestBody, ['password' => str_repeat('a', 101)]),
        ]);

    test('メールアドレスが重複している', function () use ($requestBody) {
        Spectator::using('api-docs.json');

        User::factory()->create(['email' => $requestBody['email']]);

        $this->postJson('/auth/register', $requestBody)
            ->assertValidRequest()
            ->assertValidResponse(422);
    });
});
