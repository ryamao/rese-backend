<?php

declare(strict_types=1);

use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Spectator\Spectator;

describe('ShopController', function () {
    describe('飲食店一覧取得', function () {
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
                ->assertValidResponse(200)
                ->assertJsonCount(10, 'data');
        });

        test('エリアID指定', function () {
            Spectator::using('api-docs.json');

            $area = Area::firstWhere('name', 'エリア1');
            $this->getJson("/shops?area=$area->id")
                ->assertValidRequest()
                ->assertValidResponse(200)
                ->assertJsonCount(min($area->shops->count(), 10), 'data');
        });

        test('ジャンルID指定', function () {
            Spectator::using('api-docs.json');

            $genre = Genre::firstWhere('name', 'ジャンル1');
            $this->getJson("/shops?genre=$genre->id")
                ->assertValidRequest()
                ->assertValidResponse(200)
                ->assertJsonCount(min($genre->shops->count(), 10), 'data');
        });

        test('店名検索キーワード指定', function () {
            Spectator::using('api-docs.json');

            $this->getJson('/shops?search=0')
                ->assertValidRequest()
                ->assertValidResponse(200)
                ->assertJsonCount(2, 'data');
        });

        test('ページネーション', function () {
            Spectator::using('api-docs.json');

            $this->getJson('/shops?page=2')
                ->assertValidRequest()
                ->assertValidResponse(200)
                ->assertJsonCount(10, 'data');
        });

        test('存在しないページネーション', function () {
            Spectator::using('api-docs.json');

            $this->getJson('/shops?page=123')
                ->assertValidRequest()
                ->assertValidResponse(200)
                ->assertJsonCount(0, 'data');
        });

        test('不正なページネーション', function () {
            Spectator::using('api-docs.json');

            $this->getJson('/shops?page=-1')
                ->assertValidRequest()
                ->assertValidResponse(200)
                ->assertJsonCount(10, 'data');
        });
    });

    describe('お気に入り取得', function () {
        beforeEach(function () {
            $user1 = User::factory()->create(['name' => 'user1']);
            $user2 = User::factory()->create(['name' => 'user2']);

            $shop = Shop::factory()->create(['name' => 'shop1']);
            $user2->favoriteShops()->attach($shop);
        });

        test('未ログイン', function () {
            Spectator::using('api-docs.json');

            $this->getJson('/shops')
                ->assertValidRequest()
                ->assertValidResponse(200)
                ->assertJsonPath('data.0.favorite_status', 'unknown');
        });

        test('お気に入り未登録', function () {
            Spectator::using('api-docs.json');

            $this->actingAs(User::firstWhere('name', 'user1'))
                ->getJson('/shops')
                ->assertValidRequest()
                ->assertValidResponse(200)
                ->assertJsonPath('data.0.favorite_status', 'unmarked');
        });

        test('お気に入り登録済み', function () {
            Spectator::using('api-docs.json');

            $this->actingAs(User::firstWhere('name', 'user2'))
                ->getJson('/shops')
                ->assertValidRequest()
                ->assertValidResponse(200)
                ->assertJsonPath('data.0.favorite_status', 'marked');
        });
    });
});
