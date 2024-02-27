<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Spectator\Spectator;

describe('AuthenticatedSessionControllerTest', function () {
    describe('GET /auth/status', function () {
        test('ゲスト', function () {
            Spectator::using('api-docs.json');

            $this->getJson('/auth/status')
                ->assertValidRequest()
                ->assertValidResponse(200)
                ->assertExactJson(['status' => 'guest']);
        });

        test('一般会員', function () {
            Spectator::using('api-docs.json');

            $user = User::factory()->create();

            $this->actingAs($user)
                ->getJson('/auth/status')
                ->assertValidRequest()
                ->assertValidResponse(200)
                ->assertJson(
                    fn (AssertableJson $json) => $json->where('status', 'customer')
                        ->whereType('id', 'integer')
                );
        });
    });
});
