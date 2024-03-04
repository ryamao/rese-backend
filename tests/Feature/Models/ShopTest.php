<?php

use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;

describe('App.Models.Shop', function () {
    describe('area', function () {
        test('関連するAreaが返る', function () {
            $area = Area::factory()->create();
            $shop = Shop::factory()->for($area)->create();
            $this->assertSame($area->id, $shop->area->id);
        });
    });

    describe('genre', function () {
        test('関連するGenreが返る', function () {
            $genre = Genre::factory()->create();
            $shop = Shop::factory()->for($genre)->create();
            $this->assertSame($genre->id, $shop->genre->id);
        });
    });
});
