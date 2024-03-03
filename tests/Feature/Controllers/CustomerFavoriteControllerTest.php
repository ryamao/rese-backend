<?php

use App\Models\Shop;
use App\Models\User;
use Spectator\Spectator;

describe('CustomerFavoriteController', function () {
    describe('POST /customers/{user}/shops/{shop}/favorite', function () {
        test('お気に入り登録', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();

            Spectator::using('api-docs.json');

            $response = $this->actingAs($user)
                ->postJson("/customers/{$user->id}/shops/{$shop->id}/favorite");

            $response->assertValidRequest();
            $response->assertValidResponse(201);
        });

        test('認証されていない場合はエラー', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();

            Spectator::using('api-docs.json');

            $response = $this->postJson("/customers/{$user->id}/shops/{$shop->id}/favorite");

            $response->assertValidRequest();
            $response->assertValidResponse(401);
        });

        test('別のユーザーの場合はエラー', function () {
            $user = User::factory()->create();
            $anotherUser = User::factory()->create();
            $shop = Shop::factory()->create();

            Spectator::using('api-docs.json');

            $response = $this->actingAs($anotherUser)
                ->postJson("/customers/{$user->id}/shops/{$shop->id}/favorite");

            $response->assertValidRequest();
            $response->assertValidResponse(403);
        });

        test('存在しないユーザーの場合はエラー', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();

            Spectator::using('api-docs.json');

            $response = $this->actingAs($user)
                ->postJson("/customers/9999/shops/{$shop->id}/favorite");

            $response->assertValidRequest();
            $response->assertValidResponse(404);
        });

        test('存在しない店舗の場合はエラー', function () {
            $user = User::factory()->create();

            Spectator::using('api-docs.json');

            $response = $this->actingAs($user)
                ->postJson("/customers/{$user->id}/shops/9999/favorite");

            $response->assertValidRequest();
            $response->assertValidResponse(404);
        });
    });
});
