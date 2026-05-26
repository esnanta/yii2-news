<?php

use yii\faker\FixtureController;

return [
    'controllerMap' => [
        'fixture' => [
            'class' => FixtureController::class,
            'fixtureDataPath' => '@tests/common/fixtures/data',
            'templatePath' => '@tests/common/templates/fixtures',
            'namespace' => 'tests\common\fixtures',
        ],
    ],
];
