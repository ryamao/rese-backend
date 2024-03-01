<?php

use App\Models\Area;
use Spectator\Spectator;

describe('AreaController', function () {
    test('エリア一覧を取得する', function () {
        Area::factory(3)->create();

        Spectator::using('api-docs.json');

        $this->getJson('/areas')
            ->assertValidRequest()
            ->assertValidResponse(200);
    });
});
