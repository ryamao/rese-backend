<?php

use App\Models\Favorite;
use App\Models\Shop;
use App\Models\User;

describe('App.Models.Favorite', function () {
    describe('user', function () {
        test('関連するUserが返る', function () {
            $user = User::factory()->create();
            $favorite = Favorite::factory()->for($user)->create();
            $this->assertSame($user->id, $favorite->user->id);
        });
    });

    describe('shop', function () {
        test('関連するShopが返る', function () {
            $shop = Shop::factory()->create();
            $favorite = Favorite::factory()->for($shop)->create();
            $this->assertSame($shop->id, $favorite->shop->id);
        });
    });
});
