<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Spectator\Spectator;

describe('GET /auth/status', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');
    });

    test('ゲスト', function () {
        $this->getJson('/auth/status')
            ->assertValidRequest()
            ->assertValidResponse(200)
            ->assertExactJson(['status' => 'guest']);
    });

    test('一般会員 (メール未確認)', function () {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->actingAs($user)
            ->getJson('/auth/status')
            ->assertValidRequest()
            ->assertValidResponse(200)
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('status', 'customer')
                    ->whereType('id', 'integer')
                    ->where('has_verified_email', false)
            );
    });

    test('一般会員 (メール確認済み)', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson('/auth/status')
            ->assertValidRequest()
            ->assertValidResponse(200)
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('status', 'customer')
                    ->whereType('id', 'integer')
                    ->where('has_verified_email', true)
            );
    });
});
