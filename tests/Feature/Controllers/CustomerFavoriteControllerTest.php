<?php

use App\Models\Shop;
use App\Models\User;
use Spectator\Spectator;

describe('CustomerFavoriteController', function () {
    describe('POST /customers/{customer}/shops/{shop}/favorite', function () {
        test('お気に入り登録', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();

            Spectator::using('api-docs.json');

            $response = $this->actingAs($user)
                ->postJson("/customers/{$user->id}/shops/{$shop->id}/favorite");

            $response->assertValidRequest();
            $response->assertValidResponse(201);

            $this->assertDatabaseHas('favorites', [
                'user_id' => $user->id,
                'shop_id' => $shop->id,
            ]);
        });

        test('認証されていない場合はエラー', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();

            Spectator::using('api-docs.json');

            $response = $this->postJson("/customers/{$user->id}/shops/{$shop->id}/favorite");

            $response->assertValidRequest();
            $response->assertValidResponse(401);
        });

        test('別の顧客の場合はエラー', function () {
            $user = User::factory()->create();
            $anotherUser = User::factory()->create();
            $shop = Shop::factory()->create();

            Spectator::using('api-docs.json');

            $response = $this->actingAs($anotherUser)
                ->postJson("/customers/{$user->id}/shops/{$shop->id}/favorite");

            $response->assertValidRequest();
            $response->assertValidResponse(403);
        });

        test('存在しない顧客の場合はエラー', function () {
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

        test('既にお気に入り登録されている場合はエラー', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();

            $user->favoriteShops()->attach($shop);

            Spectator::using('api-docs.json');

            $response = $this->actingAs($user)
                ->postJson("/customers/{$user->id}/shops/{$shop->id}/favorite");

            $response->assertValidRequest();
            $response->assertValidResponse(422);
        });
    });

    describe('DELETE /customers/{customer}/shops/{shop}/favorite', function () {
        test('お気に入り解除', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();
            $user->favoriteShops()->attach($shop);

            Spectator::using('api-docs.json');

            $response = $this->actingAs($user)
                ->deleteJson("/customers/{$user->id}/shops/{$shop->id}/favorite");

            $response->assertValidRequest();
            $response->assertValidResponse(204);

            $this->assertDatabaseMissing('favorites', [
                'user_id' => $user->id,
                'shop_id' => $shop->id,
            ]);
        });

        test('認証されていない場合はエラー', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();
            $user->favoriteShops()->attach($shop);

            Spectator::using('api-docs.json');

            $response = $this->deleteJson("/customers/{$user->id}/shops/{$shop->id}/favorite");

            $response->assertValidRequest();
            $response->assertValidResponse(401);
        });

        test('別の顧客の場合はエラー', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();
            $user->favoriteShops()->attach($shop);
            $anotherUser = User::factory()->create();

            Spectator::using('api-docs.json');

            $response = $this->actingAs($anotherUser)
                ->deleteJson("/customers/{$user->id}/shops/{$shop->id}/favorite");

            $response->assertValidRequest();
            $response->assertValidResponse(403);
        });

        test('存在しない顧客の場合はエラー', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();
            $user->favoriteShops()->attach($shop);

            Spectator::using('api-docs.json');

            $response = $this->actingAs($user)
                ->deleteJson("/customers/9999/shops/{$shop->id}/favorite");

            $response->assertValidRequest();
            $response->assertValidResponse(404);
        });

        test('存在しない店舗の場合はエラー', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();
            $user->favoriteShops()->attach($shop);

            Spectator::using('api-docs.json');

            $response = $this->actingAs($user)
                ->deleteJson("/customers/{$user->id}/shops/9999/favorite");

            $response->assertValidRequest();
            $response->assertValidResponse(404);
        });

        test('お気に入り登録されていない場合はエラー', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();

            Spectator::using('api-docs.json');

            $response = $this->actingAs($user)
                ->deleteJson("/customers/{$user->id}/shops/{$shop->id}/favorite");

            $response->assertValidRequest();
            $response->assertValidResponse(422);
        });
    });
});
