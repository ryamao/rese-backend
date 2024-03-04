<?php

use App\Models\Area;
use App\Models\Shop;

describe('App.Models.Area', function () {
    describe('shops', function () {
        test('関連するShopが返る', function () {
            $area = Area::factory()->create();
            $shops = Shop::factory(3)->for($area)->create();
            $this->assertSameSize($shops, $area->shops);
            $shops->zip($area->shops)->each(fn ($pair) => $this->assertSame($pair[0]->id, $pair[1]->id));
        });

        test('リレーションがない場合は空のコレクションが返る', function () {
            $area = Area::factory()->create();
            $this->assertEmpty($area->shops);
        });
    });
});
