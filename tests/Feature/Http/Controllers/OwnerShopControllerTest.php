<?php

use App\Models\Shop;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Spectator\Spectator;

describe('GET /owners/{owner}/shops', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');
        $this->seed(UserSeeder::class);

        $this->owner = User::factory()->create();
        $this->owner->assignRole('owner');

        Shop::factory(3)->create([
            'owner_id' => $this->owner->id,
        ]);
    });

    test('店舗無し', function () {
        $anotherOwner = User::factory()->create();
        $anotherOwner->assignRole('owner');

        $response = $this->actingAs($anotherOwner)
            ->getJson("/owners/{$anotherOwner->id}/shops");

        $response->assertValidRequest();
        $response->assertValidResponse(200);

        $response->assertJsonCount(0, 'data');
    });

    test('店舗一覧取得', function () {
        $response = $this->actingAs($this->owner)
            ->getJson("/owners/{$this->owner->id}/shops");

        $response->assertValidRequest();
        $response->assertValidResponse(200);

        $response->assertJsonCount(3, 'data');
    });

    test('未認証', function () {
        $response = $this->getJson("/owners/{$this->owner->id}/shops");

        $response->assertValidRequest();
        $response->assertValidResponse(401);
    });

    test('権限なし', function () {
        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $response = $this->actingAs($customer)
            ->getJson("/owners/{$this->owner->id}/shops");

        $response->assertValidRequest();
        $response->assertValidResponse(403);
    });

    test('別の店舗代表者', function () {
        $anotherOwner = User::factory()->create();
        $anotherOwner->assignRole('owner');

        $response = $this->actingAs($anotherOwner)
            ->getJson("/owners/{$this->owner->id}/shops");

        $response->assertValidRequest();
        $response->assertValidResponse(403);
    });

    test('存在しない店舗代表者', function () {
        $response = $this->actingAs($this->owner)
            ->getJson('/owners/9999/shops');

        $response->assertValidRequest();
        $response->assertValidResponse(404);
    });
});
