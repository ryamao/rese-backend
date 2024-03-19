<?php

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spectator\Spectator;

describe('POST /owners', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');

        Permission::findOrCreate('create owners');

        $role = Role::findOrCreate('admin');
        $role->givePermissionTo('create owners');

        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);
    });

    test('店舗代表者追加', function () {
        $response = $this->actingAs($this->admin)->postJson('/owners', [
            'name' => 'テストオーナー',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertValidRequest();
        $response->assertValidResponse(201);

        $owner = User::where('email', 'test@example.com')->firstOrFail();
        $this->assertSame('テストオーナー', $owner->name);
        $this->assertTrue($owner->hasRole('owner'));
    });

    test('未認証', function () {
        $response = $this->postJson('/owners', [
            'name' => 'テストオーナー',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertValidRequest();
        $response->assertValidResponse(401);

        $this->assertEmpty(User::where('email', 'test@example.com')->get());
    });

    test('権限なし', function () {
        $customer = User::factory()->create();
        $customer->assignRole(Role::findOrCreate('customer'));

        $response = $this->actingAs($customer)->postJson('/owners', [
            'name' => 'テストオーナー',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertValidRequest();
        $response->assertValidResponse(403);

        $this->assertEmpty(User::where('email', 'test@example.com')->get());
    });

    test('バリデーションエラー', function () {
        $response = $this->actingAs($this->admin)->postJson('/owners');

        $response->assertValidResponse(422);

        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    });
});
