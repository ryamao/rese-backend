<?php

use App\Models\User;
use Spectator\Spectator;

describe('CustomerController', function () {
    describe('GET /customers/{customer}', function () {
        test('顧客情報取得成功', function () {
            $user = User::factory()->create();

            Spectator::using('api-docs.json');
            $this->actingAs($user)->getJson("/customers/$user->id")
                ->assertValidRequest()
                ->assertValidResponse(200);
        });

        test('認証エラー', function () {
            $user = User::factory()->create();

            Spectator::using('api-docs.json');
            $this->getJson("/customers/$user->id")
                ->assertValidRequest()
                ->assertValidResponse(401);
        });

        test('認可エラー', function () {
            $user1 = User::factory()->create();
            $user2 = User::factory()->create();

            Spectator::using('api-docs.json');
            $this->actingAs($user2)->getJson("/customers/$user1->id")
                ->assertValidRequest()
                ->assertValidResponse(403);
        });

        test('顧客が存在しない', function () {
            $user = User::factory()->create();
            $nonExistentUserId = $user->id + 1;

            Spectator::using('api-docs.json');
            $this->actingAs($user)->getJson("/customers/$nonExistentUserId")
                ->assertValidRequest()
                ->assertValidResponse(404);
        });
    });
});
