<?php

use App\Models\Shop;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use Spectator\Spectator;

describe('GET /customers/{customer}/favorites', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');

        $this->seed(UserSeeder::class);

        $this->customers = User::factory()->count(2)->create();
        $this->customers->each(function (User $customer) {
            $customer->assignRole('customer');
        });

        $this->shops = Shop::factory()->count(15)->create();
        $this->shops->each(function (Shop $shop, int $index) {
            if ($index % 2 === 0) {
                $this->customers[0]->favoriteShops()->attach($shop);
            }
            $this->customers[1]->favoriteShops()->attach($shop);
        });
    });

    test('取得成功', function () {
        $response = $this->actingAs($this->customers[0])
            ->getJson("/customers/{$this->customers[0]->id}/favorites");

        $response->assertValidRequest();
        $response->assertValidResponse(200);
        $response->assertJsonCount(5, 'data');
        $response->assertJson(function (AssertableJson $json) {
            return $json->where('data.0.id', $this->shops[0]->id)
                ->where('data.1.id', $this->shops[2]->id)
                ->where('data.2.id', $this->shops[4]->id)
                ->where('data.3.id', $this->shops[6]->id)
                ->where('data.4.id', $this->shops[8]->id)
                ->etc();
        });
    });

    test('取得成功（ページネーション）', function () {
        $response = $this->actingAs($this->customers[0])
            ->getJson("/customers/{$this->customers[0]->id}/favorites?page=2");

        $response->assertValidRequest();
        $response->assertValidResponse(200);
        $response->assertJsonCount(3, 'data');
        $response->assertJson(function (AssertableJson $json) {
            return $json->where('data.0.id', $this->shops[10]->id)
                ->where('data.1.id', $this->shops[12]->id)
                ->where('data.2.id', $this->shops[14]->id)
                ->etc();
        });
    });

    test('お気に入りがない場合は空配列を返す', function () {
        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $response = $this->actingAs($customer)
            ->getJson("/customers/{$customer->id}/favorites");

        $response->assertValidRequest();
        $response->assertValidResponse(200);
        $response->assertJsonCount(0, 'data');
    });

    test('認証されていない場合は401エラー', function () {
        $response = $this->getJson("/customers/{$this->customers[0]->id}/favorites");

        $response->assertValidRequest();
        $response->assertValidResponse(401);
    });

    test('他のユーザーのお気に入り一覧は取得できない', function () {
        $response = $this->actingAs($this->customers[0])
            ->getJson("/customers/{$this->customers[1]->id}/favorites");

        $response->assertValidRequest();
        $response->assertValidResponse(403);
    });

    test('存在しないユーザーの場合は404エラー', function () {
        $response = $this->actingAs($this->customers[0])
            ->getJson('/customers/999/favorites');

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });
});
