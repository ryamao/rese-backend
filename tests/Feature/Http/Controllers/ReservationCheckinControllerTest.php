<?php

use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Spectator\Spectator;

describe('GET /reservations/{reservation}/signed-url', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');
        $this->seed(UserSeeder::class);

        $this->customer = User::factory()->create();
        $this->customer->assignRole('customer');

        $this->owner = User::factory()->create();
        $this->owner->assignRole('owner');

        $shop = Shop::factory()
            ->recycle($this->owner)
            ->create();

        $this->reservation = Reservation::factory()
            ->recycle($this->customer)
            ->recycle($shop)
            ->create();
    });

    test('入店確認用の署名付きURLを取得する', function () {
        $response = $this->actingAs($this->customer)
            ->getJson("/reservations/{$this->reservation->id}/signed-url");

        $response->assertValidRequest();
        $response->assertValidResponse(200);
    });

    test('未ログインの場合は401エラー', function () {
        $response = $this->getJson("/reservations/{$this->reservation->id}/signed-url");

        $response->assertValidRequest();
        $response->assertValidResponse(401);
    });

    test('権限がない場合は403エラー', function () {
        $response = $this->actingAs($this->owner)
            ->getJson("/reservations/{$this->reservation->id}/signed-url");

        $response->assertValidRequest();
        $response->assertValidResponse(403);
    });

    test('別の顧客の予約の場合は403エラー', function () {
        $otherCustomer = User::factory()->create();
        $otherCustomer->assignRole('customer');

        $response = $this->actingAs($otherCustomer)
            ->getJson("/reservations/{$this->reservation->id}/signed-url");

        $response->assertValidRequest();
        $response->assertValidResponse(403);
    });

    test('存在しない予約の場合は404エラー', function () {
        $response = $this->actingAs($this->customer)
            ->getJson('/reservations/9999/signed-url');

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });
});

describe('POST /reservations/{reservation}/checkin', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');
        $this->seed(UserSeeder::class);

        $this->customer = User::factory()->create();
        $this->customer->assignRole('customer');

        $this->owner = User::factory()->create();
        $this->owner->assignRole('owner');

        $shop = Shop::factory()
            ->recycle($this->owner)
            ->create();

        $this->reservation = Reservation::factory()
            ->recycle($this->customer)
            ->recycle($shop)
            ->create();
    });

    test('入店確認を行う', function () {
        $url = $this->actingAs($this->customer)
            ->getJson("/reservations/{$this->reservation->id}/signed-url")
            ->json('url');

        $response = $this->actingAs($this->owner)
            ->postJson($url);

        $response->assertValidRequest();
        $response->assertValidResponse(201);

        $this->assertTrue($this->reservation->fresh()->is_checked_in);
    });

    test('未ログインの場合は401エラー', function () {
        $url = $this->actingAs($this->customer)
            ->getJson("/reservations/{$this->reservation->id}/signed-url")
            ->json('url');
        $this->postJson('/auth/logout');

        $response = $this->postJson($url);

        $response->assertValidRequest();
        $response->assertValidResponse(401);
    });

    test('権限がない場合は403エラー', function () {
        $url = $this->actingAs($this->customer)
            ->getJson("/reservations/{$this->reservation->id}/signed-url")
            ->json('url');

        $response = $this->actingAs($this->customer)
            ->postJson($url);

        $response->assertValidRequest();
        $response->assertValidResponse(403);
    });

    test('別の顧客の予約の場合は403エラー', function () {
        $otherOwner = User::factory()->create();
        $otherOwner->assignRole('owner');

        $url = $this->actingAs($this->customer)
            ->getJson("/reservations/{$this->reservation->id}/signed-url")
            ->json('url');

        $response = $this->actingAs($otherOwner)
            ->postJson($url);

        $response->assertValidRequest();
        $response->assertValidResponse(403);
    });

    test('署名が不正な場合は403エラー', function () {
        $url = $this->actingAs($this->customer)
            ->getJson("/reservations/{$this->reservation->id}/signed-url")
            ->json('url');

        $response = $this->actingAs($this->owner)
            ->postJson(str_replace('signature=', 'signature=invalid', $url));

        $response->assertValidRequest();
        $response->assertValidResponse(403);
    });

    test('存在しない予約の場合は404エラー', function () {
        $url = $this->actingAs($this->customer)
            ->getJson("/reservations/{$this->reservation->id}/signed-url")
            ->json('url');

        $response = $this->actingAs($this->owner)
            ->postJson(str_replace($this->reservation->id, 9999, $url));

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });

    test('既に入店確認済みの場合は409エラー', function () {
        $this->reservation->update(['is_checked_in' => true]);

        $url = $this->actingAs($this->customer)
            ->getJson("/reservations/{$this->reservation->id}/signed-url")
            ->json('url');

        $response = $this->actingAs($this->owner)
            ->postJson($url);

        $response->assertValidRequest();
        $response->assertValidResponse(409);
    });
});
