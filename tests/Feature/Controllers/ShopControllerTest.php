<?php

declare(strict_types=1);

use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use Spectator\Spectator;

describe('ShopController', function () {
    describe('GET /shops', function () {
        beforeEach(function () {
            $areas = Area::factory(3)->create();
            $genres = Genre::factory(5)->create();
            $shops = Shop::factory(20)
                ->recycle($areas)
                ->recycle($genres)
                ->create();
            $shops->each(function ($shop, $index) {
                $shop->name = "店名{$index}";
                $shop->save();
            });
        });

        test('クエリパラメータ無し', function () {
            Spectator::using('api-docs.json');

            $this->getJson('/shops')
                ->assertValidRequest()
                ->assertValidResponse(200);
        });

        test('エリアID指定', function () {
            Spectator::using('api-docs.json');

            $this->getJson('/shops?area=1')
                ->assertValidRequest()
                ->assertValidResponse(200);
        });

        test('ジャンルID指定', function () {
            Spectator::using('api-docs.json');

            $this->getJson('/shops?genre=1')
                ->assertValidRequest()
                ->assertValidResponse(200);
        });

        test('店名検索キーワード指定', function () {
            Spectator::using('api-docs.json');

            $this->getJson('/shops?search=牛')
                ->assertValidRequest()
                ->assertValidResponse(200);
        });
    });
});
