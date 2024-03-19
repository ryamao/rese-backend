<?php

use App\Models\Shop;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Spectator\Spectator;

describe('POST /customers/{customer}/shops/{shop}/favorite', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');

        $this->seed(UserSeeder::class);

        $this->user = User::factory()->create();
        $this->user->assignRole('customer');

        $this->shop = Shop::factory()->create();
    });

    test('お気に入り登録', function () {
        $response = $this->actingAs($this->user)
            ->postJson("/customers/{$this->user->id}/shops/{$this->shop->id}/favorite");

        $response->assertValidRequest();
        $response->assertValidResponse(201);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $this->user->id,
            'shop_id' => $this->shop->id,
        ]);
    });

    test('認証されていない場合はエラー', function () {
        $response = $this->postJson("/customers/{$this->user->id}/shops/{$this->shop->id}/favorite");

        $response->assertValidRequest();
        $response->assertValidResponse(401);
    });

    test('別の顧客の場合はエラー', function () {
        $anotherUser = User::factory()->create();

        $response = $this->actingAs($anotherUser)
            ->postJson("/customers/{$this->user->id}/shops/{$this->shop->id}/favorite");

        $response->assertValidRequest();
        $response->assertValidResponse(403);
    });

    test('存在しない顧客の場合はエラー', function () {
        $response = $this->actingAs($this->user)
            ->postJson("/customers/9999/shops/{$this->shop->id}/favorite");

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });

    test('存在しない店舗の場合はエラー', function () {
        $response = $this->actingAs($this->user)
            ->postJson("/customers/{$this->user->id}/shops/9999/favorite");

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });

    test('既にお気に入り登録されている場合はエラー', function () {
        $this->user->favoriteShops()->attach($this->shop);

        $response = $this->actingAs($this->user)
            ->postJson("/customers/{$this->user->id}/shops/{$this->shop->id}/favorite");

        $response->assertValidRequest();
        $response->assertValidResponse(422);
    });
});

describe('DELETE /customers/{customer}/shops/{shop}/favorite', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');

        $this->seed(UserSeeder::class);

        $this->user = User::factory()->create();
        $this->user->assignRole('customer');

        $this->shop = Shop::factory()->create();
        $this->user->favoriteShops()->attach($this->shop);
    });

    test('お気に入り解除', function () {
        $response = $this->actingAs($this->user)
            ->deleteJson("/customers/{$this->user->id}/shops/{$this->shop->id}/favorite");

        $response->assertValidRequest();
        $response->assertValidResponse(204);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $this->user->id,
            'shop_id' => $this->shop->id,
        ]);
    });

    test('認証されていない場合はエラー', function () {
        $response = $this->deleteJson("/customers/{$this->user->id}/shops/{$this->shop->id}/favorite");

        $response->assertValidRequest();
        $response->assertValidResponse(401);
    });

    test('別の顧客の場合はエラー', function () {
        $anotherUser = User::factory()->create();

        $response = $this->actingAs($anotherUser)
            ->deleteJson("/customers/{$this->user->id}/shops/{$this->shop->id}/favorite");

        $response->assertValidRequest();
        $response->assertValidResponse(403);
    });

    test('存在しない顧客の場合はエラー', function () {
        $response = $this->actingAs($this->user)
            ->deleteJson("/customers/9999/shops/{$this->shop->id}/favorite");

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });

    test('存在しない店舗の場合はエラー', function () {
        $response = $this->actingAs($this->user)
            ->deleteJson("/customers/{$this->user->id}/shops/9999/favorite");

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });

    test('お気に入り登録されていない場合はエラー', function () {
        $this->user->favoriteShops()->detach($this->shop);

        $response = $this->actingAs($this->user)
            ->deleteJson("/customers/{$this->user->id}/shops/{$this->shop->id}/favorite");

        $response->assertValidRequest();
        $response->assertValidResponse(422);
    });
});
