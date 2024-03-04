<?php

use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Carbon;
use Spectator\Spectator;

describe('CustomerReservationController', function () {
    describe('GET /customers/{user}/shops/{shop}/reservations', function () {
        beforeEach(function () {
            Spectator::using('api-docs.json');
            Carbon::setTestNow(new Carbon('2022-03-04 12:00:00', 'Asia/Tokyo'));
        });

        afterEach(function () {
            Carbon::setTestNow();
        });

        test('取得成功', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();
            $user->reservedShops()->attach($shop, [
                'reserved_at' => new Carbon('2022-03-04 18:00:00', 'Asia/Tokyo'),
                'number_of_guests' => 2,
            ]);
            $user->reservedShops()->attach($shop, [
                'reserved_at' => new Carbon('2022-03-05 19:00:00', 'Asia/Tokyo'),
                'number_of_guests' => 4,
            ]);

            $response = $this->actingAs($user)
                ->getJson("/customers/{$user->id}/shops/{$shop->id}/reservations");

            $response->assertValidRequest();
            $response->assertValidResponse(200);

            $response->assertJsonCount(2, 'reservations');
        });

        test('リレーションがない場合は空のコレクションが返る', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();

            $response = $this->actingAs($user)
                ->getJson("/customers/{$user->id}/shops/{$shop->id}/reservations");

            $response->assertValidRequest();
            $response->assertValidResponse(200);

            $response->assertJsonCount(0, 'reservations');
        });

        test('認証が必要', function () {
            $shop = Shop::factory()->create();

            $response = $this->getJson("/customers/1/shops/{$shop->id}/reservations");

            $response->assertValidRequest();
            $response->assertValidResponse(401);
        });

        test('別のユーザーの場合は403エラー', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();
            $otherUser = User::factory()->create();

            $response = $this->actingAs($otherUser)
                ->getJson("/customers/{$user->id}/shops/{$shop->id}/reservations");

            $response->assertValidRequest();
            $response->assertValidResponse(403);
        });

        test('存在しないユーザーIDの場合は404エラー', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();

            $response = $this->actingAs($user)
                ->getJson("/customers/9999/shops/{$shop->id}/reservations");

            $response->assertValidRequest();
            $response->assertValidResponse(404);
        });

        test('存在しない店舗IDの場合は404エラー', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();

            $response = $this->actingAs($user)
                ->getJson("/customers/{$user->id}/shops/9999/reservations");

            $response->assertValidRequest();
            $response->assertValidResponse(404);
        });
    });
});
