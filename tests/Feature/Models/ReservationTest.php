<?php

use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Carbon;

describe('App.Models.Reservation', function () {
    test('reserved_atがCarbonを返す', function () {
        $reservedAt = new Carbon('2022-03-04 18:00:00');
        $user = User::factory()->create();
        $shop = Shop::factory()->create();
        $user->reservedShops()->attach($shop, [
            'reserved_at' => $reservedAt,
            'number_of_guests' => 2,
        ]);
        $reservation = Reservation::first();
        $this->assertInstanceOf(Carbon::class, $reservation->reserved_at);
        $this->assertEquals($reservedAt, $reservation->reserved_at);
    });

    test('UTC以外のタイムゾーンを保存した場合', function () {
        $reservedAt = new Carbon('2022-03-04 18:00:00', 'Asia/Tokyo');
        $user = User::factory()->create();
        $shop = Shop::factory()->create();
        $user->reservedShops()->attach($shop, [
            'reserved_at' => $reservedAt,
            'number_of_guests' => 2,
        ]);
        $reservation = Reservation::first();
        $this->assertSame('2022-03-04T18:00:00+00:00', $reservation->reserved_at->toRfc3339String());
    });

    test('userが関連するUserを返す', function () {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();
        $reservation = Reservation::factory()->for($user)->for($shop)->create();
        $this->assertSame($user->id, $reservation->user->id);
    });

    test('shopが関連するShopを返す', function () {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();
        $reservation = Reservation::factory()->for($user)->for($shop)->create();
        $this->assertSame($shop->id, $reservation->shop->id);
    });
});
