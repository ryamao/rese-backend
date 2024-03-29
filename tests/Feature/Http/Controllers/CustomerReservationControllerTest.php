<?php

use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Spectator\Spectator;

describe('GET /customers/{customer}/reservations', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');

        Date::setTestNow('2021-01-01 12:00:00');

        $this->seed(UserSeeder::class);

        $this->users = User::factory(3)->create();
        $this->users->each(function (User $user) {
            $user->assignRole('customer');
        });

        $this->shops = Shop::factory(3)->create();

        Reservation::create([
            'user_id' => $this->users[0]->id,
            'shop_id' => $this->shops[0]->id,
            'reserved_at' => Date::now()->subDay(),
            'number_of_guests' => 1,
        ]);
        Reservation::create([
            'user_id' => $this->users[0]->id,
            'shop_id' => $this->shops[0]->id,
            'reserved_at' => Date::now(),
            'number_of_guests' => 2,
        ]);
        Reservation::create([
            'user_id' => $this->users[0]->id,
            'shop_id' => $this->shops[1]->id,
            'reserved_at' => Date::now()->addDays(2),
            'number_of_guests' => 3,
        ]);
        Reservation::create([
            'user_id' => $this->users[0]->id,
            'shop_id' => $this->shops[0]->id,
            'reserved_at' => Date::now()->addDays(1),
            'number_of_guests' => 4,
        ]);

        $this->shops->each(function (Shop $shop) {
            Reservation::factory()->create([
                'user_id' => $this->users[1]->id,
                'shop_id' => $shop->id,
                'reserved_at' => Date::now()->addDays(1),
                'number_of_guests' => 5,
            ]);
        });
    });

    afterEach(function () {
        Date::setTestNow();
    });

    test('取得成功', function () {
        $response = $this->actingAs($this->users[0])
            ->getJson("/customers/{$this->users[0]->id}/reservations");

        $response->assertValidRequest();
        $response->assertValidResponse(200);
        $response->assertJsonCount(3, 'data');
        $response->assertJson(function ($json) {
            return $json
                ->where('data.0.number_of_guests', 2)
                ->where('data.1.number_of_guests', 4)
                ->where('data.2.number_of_guests', 3)
                ->etc();
        });
    });

    test('予約がない場合は空配列を返す', function () {
        $response = $this->actingAs($this->users[2])
            ->getJson("/customers/{$this->users[2]->id}/reservations");

        $response->assertValidRequest();
        $response->assertValidResponse(200);
        $response->assertJsonCount(0, 'data');
    });

    test('認証が必要', function () {
        $response = $this->getJson("/customers/{$this->users[0]->id}/reservations");

        $response->assertValidRequest();
        $response->assertValidResponse(401);
    });

    test('別の顧客の場合は403エラー', function () {
        $response = $this->actingAs($this->users[1])
            ->getJson("/customers/{$this->users[0]->id}/reservations");

        $response->assertValidRequest();
        $response->assertValidResponse(403);
    });

    test('存在しない顧客IDの場合は404エラー', function () {
        $response = $this->actingAs($this->users[0])
            ->getJson('/customers/9999/reservations');

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });
});

describe('PUT /customers/{customer}/reservations/{reservation}', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');

        Carbon::setTestNow(new Carbon('2024-01-01 00:00:00'));

        $this->seed(UserSeeder::class);

        $this->user = User::factory()->create();
        $this->user->assignRole('customer');

        $this->reservation = Reservation::create([
            'user_id' => $this->user->id,
            'shop_id' => Shop::factory()->create()->id,
            'reserved_at' => Carbon::make('2024-01-01 20:00:00')->timezone('UTC'),
            'number_of_guests' => 1,
        ]);
    });

    afterEach(function () {
        Carbon::setTestNow();
    });

    test('変更成功', function () {
        $reservedAt = Carbon::make('2024-01-01 21:00:00', 'Asia/Tokyo');

        $response = $this->actingAs($this->user)
            ->putJson("/customers/{$this->user->id}/reservations/{$this->reservation->id}", [
                'reserved_at' => $reservedAt->toRfc3339String(),
                'number_of_guests' => 2,
            ]);

        $response->assertValidRequest();
        $response->assertValidResponse(204);

        $this->assertDatabaseHas('reservations', [
            'id' => $this->reservation->id,
            'reserved_at' => $reservedAt->timezone('UTC'),
            'number_of_guests' => 2,
        ]);
    });

    test('認証が必要', function () {
        $response = $this->putJson("/customers/{$this->user->id}/reservations/{$this->reservation->id}", [
            'reserved_at' => '2024-01-01T21:00:00+09:00',
            'number_of_guests' => 2,
        ]);

        $response->assertValidRequest();
        $response->assertValidResponse(401);
    });

    test('別の顧客の場合は403エラー', function () {
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)
            ->putJson("/customers/{$this->user->id}/reservations/{$this->reservation->id}", [
                'reserved_at' => new Carbon('2024-01-01 21:00:00'),
                'number_of_guests' => 2,
            ]);

        $response->assertValidRequest();
        $response->assertValidResponse(403);
    });

    test('存在しない顧客IDの場合は404エラー', function () {
        $response = $this->actingAs($this->user)
            ->putJson('/customers/9999/reservations/1', [
                'reserved_at' => '2024-01-01T21:00:00+09:00',
                'number_of_guests' => 2,
            ]);

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });

    test('存在しない予約IDの場合は404エラー', function () {
        $response = $this->actingAs($this->user)
            ->putJson("/customers/{$this->user->id}/reservations/9999", [
                'reserved_at' => '2024-01-01T21:00:00+09:00',
                'number_of_guests' => 2,
            ]);

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });

    test('予約日時が過去の場合は422エラー', function () {
        $response = $this->actingAs($this->user)
            ->putJson("/customers/{$this->user->id}/reservations/{$this->reservation->id}", [
                'reserved_at' => '2023-12-31T23:59:59+00:00',
                'number_of_guests' => 2,
            ]);

        $response->assertValidRequest();
        $response->assertValidResponse(422);
    });
});

describe('DELETE /customers/{customer}/reservations/{reservation}', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');

        $this->seed(UserSeeder::class);

        $this->user = User::factory()->create();
        $this->user->assignRole('customer');

        $this->reservation = Reservation::factory()->create([
            'user_id' => $this->user->id,
        ]);
    });

    test('取り消し成功', function () {
        $response = $this->actingAs($this->user)
            ->deleteJson("/customers/{$this->user->id}/reservations/{$this->reservation->id}");

        $response->assertValidRequest();
        $response->assertValidResponse(204);

        $this->assertSoftDeleted($this->reservation);
    });

    test('認証が必要', function () {
        $response = $this->deleteJson("/customers/{$this->user->id}/reservations/{$this->reservation->id}");

        $response->assertValidRequest();
        $response->assertValidResponse(401);
    });

    test('別の顧客の場合は403エラー', function () {
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)
            ->deleteJson("/customers/{$this->user->id}/reservations/{$this->reservation->id}");

        $response->assertValidRequest();
        $response->assertValidResponse(403);
    });

    test('別の顧客の予約の場合は403エラー', function () {
        $otherUser = User::factory()->create();
        $otherUserReservation = Reservation::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($this->user)
            ->deleteJson("/customers/{$this->user->id}/reservations/{$otherUserReservation->id}");

        $response->assertValidRequest();
        $response->assertValidResponse(403);
    });

    test('存在しない顧客IDの場合は404エラー', function () {
        $response = $this->actingAs($this->user)
            ->deleteJson("/customers/9999/reservations/{$this->reservation->id}");

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });

    test('存在しない予約IDの場合は404エラー', function () {
        $response = $this->actingAs($this->user)
            ->deleteJson("/customers/{$this->user->id}/reservations/9999");

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });
});
