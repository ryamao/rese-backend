<?php

use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Date;
use Spectator\Spectator;

describe('GET /owners/{owner}/shops/{shop}/reservations', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');
        $this->seed(UserSeeder::class);

        Date::setTestNow('2021-01-01 00:00:00');

        $this->owner1 = User::factory()->create();
        $this->owner2 = User::factory()->create();
        $this->owner1->assignRole('owner');
        $this->owner2->assignRole('owner');

        $this->shop1 = Shop::factory()->recycle($this->owner1)->create();
        $this->shop2 = Shop::factory()->recycle($this->owner1)->create();
        $this->shop3 = Shop::factory()->recycle($this->owner2)->create();

        $customer1 = User::factory()->create();
        $customer2 = User::factory()->create();

        Reservation::factory()->create([
            'shop_id' => $this->shop1->id,
            'user_id' => $customer1->id,
            'reserved_at' => '2021-01-01 12:00:00',
            'number_of_guests' => 2,
        ]);
        Reservation::factory()->create([
            'shop_id' => $this->shop1->id,
            'user_id' => $customer2->id,
            'reserved_at' => '2021-01-01 13:00:00',
            'number_of_guests' => 3,
        ]);
        Reservation::factory()->create([
            'shop_id' => $this->shop2->id,
            'user_id' => $customer1->id,
            'reserved_at' => '2021-01-01 14:00:00',
            'number_of_guests' => 4,
        ]);
        Reservation::factory()->create([
            'shop_id' => $this->shop3->id,
            'user_id' => $customer2->id,
            'reserved_at' => '2021-01-01 15:00:00',
            'number_of_guests' => 5,
        ]);
    });

    afterEach(function () {
        Date::setTestNow();
    });

    test('取得成功', function () {
        $response = $this->actingAs($this->owner1)
            ->getJson("/owners/{$this->owner1->id}/shops/{$this->shop1->id}/reservations");

        $response->assertValidRequest();
        $response->assertValidResponse(200);

        $response->assertJsonCount(2, 'data');
    });

    test('予約なし', function () {
        $shop4 = Shop::factory()->recycle($this->owner1)->create();

        $response = $this->actingAs($this->owner1)
            ->getJson("/owners/{$this->owner1->id}/shops/{$shop4->id}/reservations");

        $response->assertValidRequest();
        $response->assertValidResponse(200);

        $response->assertJsonCount(0, 'data');
    });

    test('未認証', function () {
        $response = $this->getJson("/owners/{$this->owner1->id}/shops/{$this->shop1->id}/reservations");

        $response->assertValidRequest();
        $response->assertValidResponse(401);
    });

    test('他店舗の予約は取得できない', function () {
        $response = $this->actingAs($this->owner1)
            ->getJson("/owners/{$this->owner1->id}/shops/{$this->shop3->id}/reservations");

        $response->assertValidRequest();
        $response->assertValidResponse(403);
    });

    test('存在しない店舗代表者', function () {
        $response = $this->actingAs($this->owner1)
            ->getJson("/owners/999/shops/{$this->shop1->id}/reservations");

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });

    test('存在しない店舗', function () {
        $response = $this->actingAs($this->owner1)
            ->getJson("/owners/{$this->owner1->id}/shops/999/reservations");

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });
});
