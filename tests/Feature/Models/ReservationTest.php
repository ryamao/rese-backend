<?php

use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Carbon;

describe('App.Models.Reservation', function () {
    describe('reserved_at', function () {
        test('Carbonが返る', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();
            $user->reservedShops()->attach($shop, [
                'reserved_at' => new Carbon('2022-03-04 18:00:00', 'Asia/Tokyo'),
                'number_of_guests' => 2,
            ]);
            $reservation = Reservation::first();
            $this->assertInstanceOf(Carbon::class, $reservation->reserved_at);
        });
    });

    describe('user', function () {
        test('関連するUserが返る', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();
            $reservation = Reservation::factory()->for($user)->for($shop)->create();
            $this->assertSame($user->id, $reservation->user->id);
        });
    });

    describe('shop', function () {
        test('関連するShopが返る', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();
            $reservation = Reservation::factory()->for($user)->for($shop)->create();
            $this->assertSame($shop->id, $reservation->shop->id);
        });
    });
});
