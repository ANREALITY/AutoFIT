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
            'provide-servers-not-in-cd-use' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route' => '/order/ajax/provide-servers-not-in-cd-use',
                    'defaults' => [
                        'controller' => 'Order\Controller\Ajax',
                        'action' => 'provideServersNotInCdUse'
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
    'form_elements' => [
        'factories' => [
            // forms
            'MasterData\Form\ServerForm' => 'MasterData\Form\Factory\ServerFormFactory',
            // fieldsets
            'MasterData\Form\Fieldset\ServerAdditionalName' => 'MasterData\Form\Fieldset\Factory\ServerAdditionalNameFieldsetFactory'
        ],
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