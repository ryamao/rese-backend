<?php

use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Spectator\Spectator;

describe('GET /shops/{shop}/reviews', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');
        $this->seed(UserSeeder::class);

        $this->customer1 = User::factory()->create();
        $this->customer1->assignRole('customer');
        $this->customer2 = User::factory()->create();
        $this->customer2->assignRole('customer');

        $this->owner = User::factory()->create();
        $this->owner->assignRole('owner');

        $this->shop = Shop::factory()
            ->recycle($this->owner)
            ->create();

        $this->reservations = Reservation::factory(2)
            ->recycle([$this->customer1, $this->customer2])
            ->recycle($this->shop)
            ->create([
                'is_checked_in' => true,
            ]);

        $this->reviews = \App\Models\Review::factory(2)
            ->recycle([$this->customer1, $this->customer2])
            ->recycle($this->shop)
            ->create();
    });

    test('取得成功', function () {
        $response = $this->getJson("/shops/{$this->shop->id}/reviews");

        $response->assertValidRequest();
        $response->assertValidResponse(200);

        $response->assertJsonCount(2, 'data');
    });

    test('レビューが存在しない場合', function () {
        $this->reviews->each(fn ($review) => $review->delete());

        $response = $this->getJson("/shops/{$this->shop->id}/reviews");

        $response->assertValidRequest();
        $response->assertValidResponse(200);

        $response->assertJsonCount(0, 'data');
    });

    test('店舗が存在しない場合', function () {
        $response = $this->getJson('/shops/9999/reviews');

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });
});
