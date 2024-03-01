<?php

declare(strict_types=1);

use Spectator\Spectator;

describe('GenreController', function () {
    test('ジャンル一覧を取得する', function () {
        Spectator::using('api-docs.json');

        $this->getJson('/genres')
            ->assertValidRequest()
            ->assertValidResponse(200);
    });
});
