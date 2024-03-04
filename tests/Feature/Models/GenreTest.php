<?php

use App\Models\Genre;
use App\Models\Shop;

describe('App.Models.Genre', function () {
    describe('shops', function () {
        test('関連するShopが返る', function () {
            $genre = Genre::factory()->create();
            $shops = Shop::factory(3)->for($genre)->create();
            $this->assertSameSize($shops, $genre->shops);
            $shops->zip($genre->shops)->each(fn ($pair) => $this->assertSame($pair[0]->id, $pair[1]->id));
        });

        test('リレーションがない場合は空のコレクションが返る', function () {
            $genre = Genre::factory()->create();
            $this->assertEmpty($genre->shops);
        });
    });
});
