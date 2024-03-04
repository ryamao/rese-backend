<?php

use App\Models\Reservation;
use App\Models\User;
use Spectator\Spectator;

describe('CustomerReservationController', function () {
    describe('DELETE /customers/{customer}/reservations/{reservation}', function () {
        beforeEach(function () {
            Spectator::using('api-docs.json');

            $this->user = User::factory()->create();
            $this->reservation = Reservation::factory()->create([
                'user_id' => $this->user->id,
            ]);
        });

        test('取り消し成功', function () {
            $response = $this->actingAs($this->user)
                ->deleteJson("/customers/{$this->user->id}/reservations/{$this->reservation->id}");

            $response->assertValidRequest();
            $response->assertValidResponse(204);

            $this->assertDatabaseMissing('reservations', [
                'id' => $this->reservation->id,
            ]);
        });

        test('認証が必要', function () {
            $response = $this->deleteJson("/customers/{$this->user->id}/reservations/{$this->reservation->id}");

            $response->assertValidRequest();
            $response->assertValidResponse(401);
        });

        test('別の顧客の場合は403エラー', function () {
            $otherUser = User::factory()->create();

            $response = $this->actingAs($otherUser)
                ->deleteJson("/customers/{$this->user->id}/reservations/{$this->reservation->id}");

            $response->assertValidRequest();
            $response->assertValidResponse(403);
        });

        test('存在しない顧客IDの場合は404エラー', function () {
            $response = $this->actingAs($this->user)
                ->deleteJson("/customers/9999/reservations/{$this->reservation->id}");

            $response->assertValidRequest();
            $response->assertValidResponse(404);
        });

        test('存在しない予約IDの場合は404エラー', function () {
            $response = $this->actingAs($this->user)
                ->deleteJson("/customers/{$this->user->id}/reservations/9999");

            $response->assertValidRequest();
            $response->assertValidResponse(404);
        });
    });
});
