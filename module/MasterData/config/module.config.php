<?php
return [
    'router' => [
        'routes' => [
            'edit-server' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route' => '/master-data/server/edit',
                    'defaults' => [
                        'controller' => 'MasterData\Controller\Server',
                        'action' => 'edit'
                    ]
                ]
            ],
        ]
    ],
    'controllers' => [
        'invokables' => [],
        'factories' => [
            'MasterData\Controller\Server' => 'MasterData\Controller\Factory\ServerControllerFactory'
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ],
        'strategies' => [
            'ViewJsonStrategy'
        ]
    ],
];