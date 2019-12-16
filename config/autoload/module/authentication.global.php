<?php
use Application\Controller\IndexController;

return [
    'access_filter' => [
        'options' => [
            'mode' => 'restrictive'
        ],
        'controllers' => [
            IndexController::class => [
                // ['actions' => ['index'], 'allow' => '*'],
                // ['actions' => ['...'], 'allow' => '@']
            ],
        ]
    ],
];
