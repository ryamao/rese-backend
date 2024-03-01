<?php

declare(strict_types=1);

use App\Models\Genre;
use Spectator\Spectator;

describe('GenreController', function () {
    test('ジャンル一覧を取得する', function () {
        Genre::factory(5)->create();

        Spectator::using('api-docs.json');

        $this->getJson('/genres')
            ->assertValidRequest()
            ->assertValidResponse(200);
    });
});
