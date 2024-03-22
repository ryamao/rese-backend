<?php

use App\Models\Shop;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

describe('POST /owners/{owner}/shops', function () {
    beforeEach(function () {
        Storage::fake('public');

        Spectator::using('api-docs.json');
        $this->seed(UserSeeder::class);

        $this->owner = User::factory()->create();
        $this->owner->assignRole('owner');
    });

    test('店舗登録', function () {
        $response = $this->actingAs($this->owner)
            ->withHeaders([
                'Content-Type' => 'multipart/form-data',
            ])
            ->postJson("/owners/{$this->owner->id}/shops", [
                'name' => 'テスト店舗',
                'area' => 'テストエリア',
                'genre' => 'テストジャンル',
                'detail' => 'サンプルテキスト',
                'image' => UploadedFile::fake()->image('test.jpg'),
            ]);

        $response->assertValidResponse(201);

        Storage::disk('public')->assertExists('shop_images/'.$response['data']['id'].'.jpg');
    });

    test('未認証', function () {
        $response = $this
            ->withHeaders([
                'Content-Type' => 'multipart/form-data',
            ])
            ->postJson("/owners/{$this->owner->id}/shops", [
                'name' => 'テスト店舗',
                'area' => 'テストエリア',
                'genre' => 'テストジャンル',
                'detail' => 'サンプルテキスト',
                'image' => UploadedFile::fake()->image('test.jpg'),
            ]);

        $response->assertValidResponse(401);
    });

    test('権限なし', function () {
        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $response = $this->actingAs($customer)
            ->withHeaders([
                'Content-Type' => 'multipart/form-data',
            ])
            ->postJson("/owners/{$this->owner->id}/shops", [
                'name' => 'テスト店舗',
                'area' => 'テストエリア',
                'genre' => 'テストジャンル',
                'detail' => 'サンプルテキスト',
                'image' => UploadedFile::fake()->image('test.jpg'),
            ]);

        $response->assertValidResponse(403);
    });

    test('別の店舗代表者', function () {
        $anotherOwner = User::factory()->create();
        $anotherOwner->assignRole('owner');

        $response = $this->actingAs($anotherOwner)
            ->withHeaders([
                'Content-Type' => 'multipart/form-data',
            ])
            ->postJson("/owners/{$this->owner->id}/shops", [
                'name' => 'テスト店舗',
                'area' => 'テストエリア',
                'genre' => 'テストジャンル',
                'detail' => 'サンプルテキスト',
                'image' => UploadedFile::fake()->image('test.jpg'),
            ]);

        $response->assertValidResponse(403);
    });

    test('存在しない店舗代表者', function () {
        $response = $this->actingAs($this->owner)
            ->withHeaders([
                'Content-Type' => 'multipart/form-data',
            ])
            ->postJson('/owners/9999/shops', [
                'name' => 'テスト店舗',
                'area' => 'テストエリア',
                'genre' => 'テストジャンル',
                'detail' => 'サンプルテキスト',
                'image' => UploadedFile::fake()->image('test.jpg'),
            ]);

        $response->assertValidResponse(404);
    });

    test('バリデーションエラー', function () {
        $response = $this->actingAs($this->owner)
            ->withHeaders([
                'Content-Type' => 'multipart/form-data',
            ])
            ->postJson("/owners/{$this->owner->id}/shops");

        $response->assertValidResponse(422);

        $response->assertJsonValidationErrors([
            'name', 'area', 'genre', 'detail', 'image',
        ]);
    });
});

describe('PUT /owners/{owner}/shops/{shop}', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');
        $this->seed(UserSeeder::class);

        $this->owner = User::factory()->create();
        $this->owner->assignRole('owner');

        $this->shop = Shop::factory()->create([
            'owner_id' => $this->owner->id,
        ]);
    });

    test('店舗更新', function () {
        $response = $this->actingAs($this->owner)
            ->withHeaders([
                'Content-Type' => 'multipart/form-data',
            ])
            ->putJson("/owners/{$this->owner->id}/shops/{$this->shop->id}", [
                'name' => '更新店舗',
                'area' => '更新エリア',
                'genre' => '更新ジャンル',
                'detail' => '更新テキスト',
                'image' => UploadedFile::fake()->image('update.jpg'),
            ]);

        $response->assertValidResponse(204);

        $this->shop->refresh();

        expect($this->shop->name)->toBe('更新店舗');
        expect($this->shop->area->name)->toBe('更新エリア');
        expect($this->shop->genre->name)->toBe('更新ジャンル');
        expect($this->shop->detail)->toBe('更新テキスト');
        expect($this->shop->image_url)->toBe(env('APP_URL').Storage::url('shop_images/'.$this->shop->id.'.jpg'));
    });

    test('更新無し', function () {
        $name = $this->shop->name;
        $area = $this->shop->area->name;
        $genre = $this->shop->genre->name;
        $detail = $this->shop->detail;
        $imageUrl = $this->shop->image_url;

        $response = $this->actingAs($this->owner)
            ->withHeaders([
                'Content-Type' => 'multipart/form-data',
            ])
            ->putJson("/owners/{$this->owner->id}/shops/{$this->shop->id}", [
                'name' => $name,
                'area' => $area,
                'genre' => $genre,
                'detail' => $detail,
            ]);

        $response->assertValidResponse(204);

        $this->shop->refresh();

        expect($this->shop->name)->toBe($name);
        expect($this->shop->area->name)->toBe($area);
        expect($this->shop->genre->name)->toBe($genre);
        expect($this->shop->detail)->toBe($detail);
        expect($this->shop->image_url)->toBe($imageUrl);
    });

    test('未認証', function () {
        $response = $this
            ->withHeaders([
                'Content-Type' => 'multipart/form-data',
            ])
            ->putJson("/owners/{$this->owner->id}/shops/{$this->shop->id}", [
                'name' => '更新店舗',
                'area' => '更新エリア',
                'genre' => '更新ジャンル',
                'detail' => '更新テキスト',
                'image' => UploadedFile::fake()->image('update.jpg'),
            ]);

        $response->assertValidResponse(401);
    });

    test('権限なし', function () {
        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $response = $this->actingAs($customer)
            ->withHeaders([
                'Content-Type' => 'multipart/form-data',
            ])
            ->putJson("/owners/{$this->owner->id}/shops/{$this->shop->id}", [
                'name' => '更新店舗',
                'area' => '更新エリア',
                'genre' => '更新ジャンル',
                'detail' => '更新テキスト',
                'image' => UploadedFile::fake()->image('update.jpg'),
            ]);

        $response->assertValidResponse(403);
    });

    test('別の店舗代表者', function () {
        $anotherOwner = User::factory()->create();
        $anotherOwner->assignRole('owner');

        $response = $this->actingAs($anotherOwner)
            ->withHeaders([
                'Content-Type' => 'multipart/form-data',
            ])
            ->putJson("/owners/{$this->owner->id}/shops/{$this->shop->id}", [
                'name' => '更新店舗',
                'area' => '更新エリア',
                'genre' => '更新ジャンル',
                'detail' => '更新テキスト',
                'image' => UploadedFile::fake()->image('update.jpg'),
            ]);

        $response->assertValidResponse(403);
    });

    test('存在しない店舗代表者', function () {
        $response = $this->actingAs($this->owner)
            ->withHeaders([
                'Content-Type' => 'multipart/form-data',
            ])
            ->putJson('/owners/9999/shops/9999', [
                'name' => '更新店舗',
                'area' => '更新エリア',
                'genre' => '更新ジャンル',
                'detail' => '更新テキスト',
                'image' => UploadedFile::fake()->image('update.jpg'),
            ]);

        $response->assertValidResponse(404);
    });

    test('存在しない店舗', function () {
        $response = $this->actingAs($this->owner)
            ->withHeaders([
                'Content-Type' => 'multipart/form-data',
            ])
            ->putJson("/owners/{$this->owner->id}/shops/9999", [
                'name' => '更新店舗',
                'area' => '更新エリア',
                'genre' => '更新ジャンル',
                'detail' => '更新テキスト',
                'image' => UploadedFile::fake()->image('update.jpg'),
            ]);

        $response->assertValidResponse(404);
    });

    test('バリデーションエラー', function () {
        $response = $this->actingAs($this->owner)
            ->withHeaders([
                'Content-Type' => 'multipart/form-data',
            ])
            ->putJson("/owners/{$this->owner->id}/shops/{$this->shop->id}");

        $response->assertValidResponse(422);

        $response->assertJsonValidationErrors([
            'name', 'area', 'genre', 'detail',
        ]);
    });
});
