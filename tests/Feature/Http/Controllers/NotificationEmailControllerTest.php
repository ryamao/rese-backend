<?php

use App\Mail\NotificationEmail;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Mail;
use Spectator\Spectator;

describe('POST /notification-email', function () {
    beforeEach(function () {
        Spectator::using('api-docs.json');
        Mail::fake();
        $this->seed(UserSeeder::class);

        $this->admin = User::role('admin')->first();

        $this->customer = User::factory()->create();
        $this->customer->assignRole('customer');

        $this->owner = User::factory()->create();
        $this->owner->assignRole('owner');
    });

    test('送信成功', function () {
        $response = $this->actingAs($this->admin)->postJson('/notification-email', [
            'title' => 'タイトル',
            'body' => '本文',
        ]);

        $response->assertValidRequest();
        $response->assertValidResponse(201);

        Mail::assertSent(
            NotificationEmail::class,
            fn (NotificationEmail $mail) => $mail->hasTo($this->customer->email)
        );

        Mail::assertNotSent(
            NotificationEmail::class,
            fn (NotificationEmail $mail) => $mail->hasTo($this->owner->email)
        );
    });

    test('未認証', function () {
        $response = $this->postJson('/notification-email', [
            'title' => 'タイトル',
            'body' => '本文',
        ]);

        $response->assertValidRequest();
        $response->assertValidResponse(401);

        Mail::assertNothingSent();
    });

    test('権限なし', function () {
        $response = $this->actingAs($this->owner)->postJson('/notification-email', [
            'title' => 'タイトル',
            'body' => '本文',
        ]);

        $response->assertValidRequest();
        $response->assertValidResponse(403);

        Mail::assertNothingSent();
    });

    test('バリデーションエラー', function () {
        $response = $this->actingAs($this->admin)->postJson('/notification-email');

        $response->assertValidResponse(422);
        $response->assertJsonValidationErrors(['title', 'body']);

        Mail::assertNothingSent();
    });
});
