<?php

use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Carbon;

describe('App.Models.User', function () {
    describe('favoriteShops', function () {
        test('関連するShopが返る', function () {
            $user = User::factory()->create();
            $shops = Shop::factory(2)->create();
            Shop::factory(3)->create();
            $shops->each(
                fn ($shop) => Favorite::factory()->for($user)->for($shop)->create()
            );
            $this->assertSameSize($shops, $user->favoriteShops);
            $shops->zip($user->favoriteShops)->each(fn ($pair) => $this->assertSame($pair[0]->id, $pair[1]->id));
        });

        test('リレーションがない場合は空のコレクションが返る', function () {
            $user = User::factory()->create();
            Shop::factory(3)->create();
            $this->assertEmpty($user->favoriteShops);
        });

        test('Shopを関連付けできる', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();
            $user->favoriteShops()->attach($shop);
            $this->assertDatabaseHas('favorites', [
                'user_id' => $user->id,
                'shop_id' => $shop->id,
            ]);
        });

        test('Shopを関連解除できる', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();
            Favorite::factory()->for($user)->for($shop)->create();
            $user->favoriteShops()->detach($shop);
            $this->assertDatabaseMissing('favorites', [
                'user_id' => $user->id,
                'shop_id' => $shop->id,
            ]);
        });
    });

    describe('reservations', function () {
        test('関連するReservationが返る', function () {
            $user = User::factory()->create();
            $shop = Shop::factory()->create();
            $reservations = Reservation::factory(2)->for($user)->for($shop)->create();
            Reservation::factory(3)->create();
            $this->assertSameSize($reservations, $user->reservations);
            $reservations->zip($user->reservations)->each(fn ($pair) => $this->assertSame($pair[0]->id, $pair[1]->id));
        });

        test('リレーションがない場合は空のコレクションが返る', function () {
            $user = User::factory()->create();
            Reservation::factory(3)->create();
            $this->assertEmpty($user->reservations);
        });

        test('Shopを関連付けできる', function () {
            $datetime = new Carbon('2022-03-04 18:00:00', 'Asia/Tokyo');
            $user = User::factory()->create();
            $shop = Shop::factory()->create();
            $user->reservations()->create([
                'shop_id' => $shop->id,
                'reserved_at' => $datetime,
                'number_of_guests' => 2,
            ]);
            $this->assertDatabaseHas('reservations', [
                'user_id' => $user->id,
                'shop_id' => $shop->id,
                'reserved_at' => $datetime,
                'number_of_guests' => 2,
            ]);
        });
    });

    describe('reservedShops', function () {
        test('関連するShopが返る', function () {
            $user = User::factory()->create();
            $shops = Shop::factory(2)->create();
            Shop::factory(3)->create();
            $shops->each(
                fn ($shop) => Reservation::factory()->for($user)->for($shop)->create()
            );
            $this->assertSameSize($shops, $user->reservedShops);
            $shops->zip($user->reservedShops)->each(fn ($pair) => $this->assertSame($pair[0]->id, $pair[1]->id));
        });

        test('リレーションがない場合は空のコレクションが返る', function () {
            $user = User::factory()->create();
            Reservation::factory(3)->create();
            $this->assertEmpty($user->reservedShops);
        });

        test('Shopを関連付けできる', function () {
            $datetime = new Carbon('2022-03-04 18:00:00', 'Asia/Tokyo');
            $user = User::factory()->create();
            $shop = Shop::factory()->create();
            $user->reservedShops()->attach($shop, [
                'reserved_at' => $datetime,
                'number_of_guests' => 2,
            ]);
            $this->assertDatabaseHas('reservations', [
                'user_id' => $user->id,
                'shop_id' => $shop->id,
                'reserved_at' => $datetime,
                'number_of_guests' => 2,
            ]);
        });
    });
});
