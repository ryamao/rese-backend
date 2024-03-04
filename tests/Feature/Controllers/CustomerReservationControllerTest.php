<?php

use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Carbon;
use Spectator\Spectator;

describe('CustomerReservationController', function () {
    describe('GET /customers/{user}/shops/{shop}/reservations', function () {
        beforeEach(function () {
            Spectator::using('api-docs.json');
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

    describe('POST /customers/{user}/shops/{shop}/reservations', function () {
        beforeEach(function () {
            Spectator::using('api-docs.json');

            Carbon::setTestNow('2022-03-01 00:00:00');

            $this->user = User::factory()->create();
            $this->shop = Shop::factory()->create();
        });

        test('追加成功', function () {
            $reservedAt = new Carbon('2022-03-04 18:00:00', 'Asia/Tokyo');

            $response = $this->actingAs($this->user)
                ->postJson("/customers/{$this->user->id}/shops/{$this->shop->id}/reservations", [
                    'reserved_at' => $reservedAt->toRfc3339String(),
                    'number_of_guests' => 2,
                ]);

            $response->assertValidRequest();
            $response->assertValidResponse(201);

            $this->assertDatabaseHas('reservations', [
                'user_id' => $this->user->id,
                'shop_id' => $this->shop->id,
                'reserved_at' => $reservedAt,
                'number_of_guests' => 2,
            ]);
        });

        test('同じ店舗に追加可能', function () {
            $this->user->reservedShops()->attach($this->shop, [
                'reserved_at' => new Carbon('2022-03-04 18:00:00', 'Asia/Tokyo'),
                'number_of_guests' => 2,
            ]);

            $reservedAt = new Carbon('2022-03-05 19:00:00', 'Asia/Tokyo');
            $response = $this->actingAs($this->user)
                ->postJson("/customers/{$this->user->id}/shops/{$this->shop->id}/reservations", [
                    'reserved_at' => $reservedAt->toRfc3339String(),
                    'number_of_guests' => 4,
                ]);

            $response->assertValidRequest();
            $response->assertValidResponse(201);

            $this->assertDatabaseHas('reservations', [
                'user_id' => $this->user->id,
                'shop_id' => $this->shop->id,
                'reserved_at' => $reservedAt,
                'number_of_guests' => 4,
            ]);
        });

        test('認証が必要', function () {
            $response = $this->postJson("/customers/1/shops/{$this->shop->id}/reservations", [
                'reserved_at' => '2022-03-04T18:00:00+09:00',
                'number_of_guests' => 2,
            ]);

            $response->assertValidRequest();
            $response->assertValidResponse(401);
        });

        test('別のユーザーの場合は403エラー', function () {
            $otherUser = User::factory()->create();

            $response = $this->actingAs($otherUser)
                ->postJson("/customers/{$this->user->id}/shops/{$this->shop->id}/reservations", [
                    'reserved_at' => '2022-03-04T18:00:00+09:00',
                    'number_of_guests' => 2,
                ]);

            $response->assertValidRequest();
            $response->assertValidResponse(403);
        });

        test('存在しないユーザーIDの場合は404エラー', function () {
            $response = $this->actingAs($this->user)
                ->postJson("/customers/9999/shops/{$this->shop->id}/reservations", [
                    'reserved_at' => '2022-03-04T18:00:00+09:00',
                    'number_of_guests' => 2,
                ]);

            $response->assertValidRequest();
            $response->assertValidResponse(404);
        });

        test('存在しない店舗IDの場合は404エラー', function () {
            $response = $this->actingAs($this->user)
                ->postJson("/customers/{$this->user->id}/shops/9999/reservations", [
                    'reserved_at' => '2022-03-04T18:00:00+09:00',
                    'number_of_guests' => 2,
                ]);

            $response->assertValidRequest();
            $response->assertValidResponse(404);
        });

        test('未入力の場合は422エラー', function () {
            $response = $this->actingAs($this->user)
                ->postJson("/customers/{$this->user->id}/shops/{$this->shop->id}/reservations");

            $response->assertValidResponse(422);
        });

        test('予約日時のフォーマットが不正な場合は422エラー', function () {
            $response = $this->actingAs($this->user)
                ->postJson("/customers/{$this->user->id}/shops/{$this->shop->id}/reservations", [
                    'reserved_at' => '2022-03-04 18:00:00',
                    'number_of_guests' => 2,
                ]);

            $response->assertValidResponse(422);
        });

        test('予約日時が過去の場合は422エラー', function () {
            $response = $this->actingAs($this->user)
                ->postJson("/customers/{$this->user->id}/shops/{$this->shop->id}/reservations", [
                    'reserved_at' => '2022-02-28T18:00:00+09:00',
                    'number_of_guests' => 2,
                ]);

            $response->assertValidResponse(422);
        });

        test('人数が0以下の場合は422エラー', function () {
            $response = $this->actingAs($this->user)
                ->postJson("/customers/{$this->user->id}/shops/{$this->shop->id}/reservations", [
                    'reserved_at' => '2022-03-04T18:00:00+09:00',
                    'number_of_guests' => 0,
                ]);

            $response->assertValidResponse(422);
        });

        test('人数が文字列の場合は422エラー', function () {
            $response = $this->actingAs($this->user)
                ->postJson("/customers/{$this->user->id}/shops/{$this->shop->id}/reservations", [
                    'reserved_at' => '2022-03-04T18:00:00+09:00',
                    'number_of_guests' => 'invalid',
                ]);

            $response->assertValidResponse(422);
        });
    });
});
