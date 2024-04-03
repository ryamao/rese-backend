<?php

use App\Models\Rating;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Spectator\Spectator;

describe('POST /shops/{shop}/rating', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');
        $this->seed(UserSeeder::class);

        $this->customer = User::factory()->create();
        $this->customer->assignRole('customer');

        $this->owner = User::factory()->create();
        $this->owner->assignRole('owner');

        $this->shop = Shop::factory()
            ->recycle($this->owner)
            ->create();

        $this->reservation = Reservation::factory()
            ->recycle($this->customer)
            ->recycle($this->shop)
            ->create();
    });

    test('登録成功', function () {
        $response = $this->actingAs($this->customer)
            ->postJson("/shops/{$this->shop->id}/rating", [
                'rating' => 5,
            ]);

        $response->assertValidRequest();
        $response->assertValidResponse(201);

        $this->assertDatabaseHas('ratings', [
            'shop_id' => $this->shop->id,
            'user_id' => $this->customer->id,
            'number_of_stars' => 5,
        ]);
    });

    test('評価済み', function () {
        Rating::create([
            'shop_id' => $this->shop->id,
            'user_id' => $this->customer->id,
            'number_of_stars' => 5,
        ]);

        $response = $this->actingAs($this->customer)
            ->postJson("/shops/{$this->shop->id}/rating", [
                'rating' => 3,
            ]);

        $response->assertValidRequest();
        $response->assertValidResponse(201);

        $this->assertDatabaseCount('ratings', 1);
        $this->assertDatabaseHas('ratings', [
            'shop_id' => $this->shop->id,
            'user_id' => $this->customer->id,
            'number_of_stars' => 3,
        ]);
    });

    test('未認証', function () {
        $response = $this->postJson("/shops/{$this->shop->id}/rating", [
            'rating' => 5,
        ]);

        $response->assertValidRequest();
        $response->assertValidResponse(401);
    });

    test('店舗オーナーは評価できない', function () {
        $response = $this->actingAs($this->owner)
            ->postJson("/shops/{$this->shop->id}/rating", [
                'rating' => 5,
            ]);

        $response->assertValidRequest();
        $response->assertValidResponse(403);
    });

    test('店舗が存在しない', function () {
        $response = $this->actingAs($this->customer)
            ->postJson('/shops/9999/rating', [
                'rating' => 5,
            ]);

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });

    test('評価が未入力', function () {
        $response = $this->actingAs($this->customer)
            ->postJson("/shops/{$this->shop->id}/rating");

        $response->assertValidResponse(422);
    });

    test('評価が範囲外', function () {
        $response = $this->actingAs($this->customer)
            ->postJson("/shops/{$this->shop->id}/rating", [
                'rating' => 6,
            ]);

        $response->assertValidResponse(422);
    });
});
