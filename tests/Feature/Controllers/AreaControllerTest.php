<?php

use Spectator\Spectator;

describe('AreaController', function () {
    test('エリア一覧を取得する', function () {
        Spectator::using('api-docs.json');

        $this->getJson('/areas')
            ->assertValidRequest()
            ->assertValidResponse(200);
    });
});
