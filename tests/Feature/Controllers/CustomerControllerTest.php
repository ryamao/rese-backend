<?php

use App\Models\User;
use Database\Seeders\UserSeeder;
use Spectator\Spectator;

describe('GET /customers/{customer}', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');

        $this->seed(UserSeeder::class);

        $this->user = User::factory()->create();
        $this->user->assignRole('customer');
    });

    test('顧客情報取得成功', function () {
        $this->actingAs($this->user)->getJson("/customers/{$this->user->id}")
            ->assertValidRequest()
            ->assertValidResponse(200);
    });

    test('認証エラー', function () {
        $this->getJson("/customers/{$this->user->id}")
            ->assertValidRequest()
            ->assertValidResponse(401);
    });

    test('認可エラー', function () {
        $anotherUser = User::factory()->create();

        $this->actingAs($anotherUser)->getJson("/customers/{$this->user->id}")
            ->assertValidRequest()
            ->assertValidResponse(403);
    });

    test('顧客が存在しない', function () {
        $nonExistentUserId = $this->user->id + 1;

        $this->actingAs($this->user)->getJson("/customers/$nonExistentUserId")
            ->assertValidRequest()
            ->assertValidResponse(404);
    });
});
