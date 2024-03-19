<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Spatie\Permission\Models\Role;
use Spectator\Spectator;

describe('GET /auth/status', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');
    });

    test('ゲスト', function () {
        $this->getJson('/auth/status')
            ->assertValidRequest()
            ->assertValidResponse(200)
            ->assertExactJson(['status' => 'guest']);
    });

    test('管理者', function () {
        $admin = User::factory()->create();
        $role = Role::create(['name' => 'admin']);
        $admin->assignRole($role);

        $this->actingAs($admin)
            ->getJson('/auth/status')
            ->assertValidRequest()
            ->assertValidResponse(200)
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('status', 'admin')
                    ->whereType('id', 'integer')
                    ->where('has_verified_email', true)
            );
    });

    test('一般会員 (メール未確認)', function () {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->actingAs($user)
            ->getJson('/auth/status')
            ->assertValidRequest()
            ->assertValidResponse(200)
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('status', 'customer')
                    ->whereType('id', 'integer')
                    ->where('has_verified_email', false)
            );
    });

    test('一般会員 (メール確認済み)', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson('/auth/status')
            ->assertValidRequest()
            ->assertValidResponse(200)
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('status', 'customer')
                    ->whereType('id', 'integer')
                    ->where('has_verified_email', true)
            );
    });
});
