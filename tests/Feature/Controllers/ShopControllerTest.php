<?php

declare(strict_types=1);

use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Spectator\Spectator;

describe('ShopController', function () {
    describe('GET /shops', function () {
        beforeEach(function () {
            $areas = Area::factory(3)
                ->state(new Sequence(
                    fn (Sequence $sequence) => ['name' => "エリア{$sequence->index}"],
                ))
                ->create();

            $genres = Genre::factory(5)
                ->state(new Sequence(
                    fn (Sequence $sequence) => ['name' => "ジャンル{$sequence->index}"],
                ))
                ->create();

            Shop::factory(20)
                ->recycle($areas)
                ->recycle($genres)
                ->state(new Sequence(
                    fn (Sequence $sequence) => ['name' => "店名{$sequence->index}"],
                ))
                ->create();
        });

        test('クエリパラメータ無し', function () {
            Spectator::using('api-docs.json');

            $this->getJson('/shops')
                ->assertValidRequest()
                ->assertValidResponse(200);
        });

        test('エリアID指定', function () {
            Spectator::using('api-docs.json');

            $area = Area::firstWhere('name', 'エリア1');
            $this->getJson("/shops?area=$area->id")
                ->assertValidRequest()
                ->assertValidResponse(200);
        });

        test('ジャンルID指定', function () {
            Spectator::using('api-docs.json');

            $genre = Genre::firstWhere('name', 'ジャンル1');
            $this->getJson("/shops?genre=$genre->id")
                ->assertValidRequest()
                ->assertValidResponse(200);
        });

        test('店名検索キーワード指定', function () {
            Spectator::using('api-docs.json');

            $this->getJson('/shops?search=0')
                ->assertValidRequest()
                ->assertValidResponse(200);
        });

        test('ページネーション', function () {
            Spectator::using('api-docs.json');

            $this->getJson('/shops?page=2')
                ->assertValidRequest()
                ->assertValidResponse(200);
        });
    });
});
