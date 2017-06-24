<?php
return [
    'router' => [
        'routes' => [
            'master-data' => [
                'type' => 'Zend\Router\Http\Segment',
                'options' => [
                    'route' => '/master-data',
                    'defaults' => [
                        'controller' => 'MasterData\Controller\Index',
                        'action' => 'index'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'edit-server' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/server/edit',
                            'defaults' => [
                                'controller' => 'MasterData\Controller\Server',
                                'action' => 'edit'
                            ]
                        ]
                    ],
                    'create-cluster' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/cluster/create',
                            'defaults' => [
                                'controller' => 'MasterData\Controller\Cluster',
                                'action' => 'create'
                            ]
                        ]
                    ],
                ]
            ],
            'provide-servers-not-in-cd-use' => [
                'type' => 'Zend\Router\Http\Literal',
                'options' => [
                    'route' => '/order/ajax/provide-servers-not-in-cd-use',
                    'defaults' => [
                        'controller' => 'Order\Controller\Ajax',
                        'action' => 'provideServersNotInCdUse'
                    ]
                ]
            ],
            'provide-servers-not-in-cluster' => [
                'type' => 'Zend\Router\Http\Literal',
                'options' => [
                    'route' => '/order/ajax/provide-servers-not-in-cluster',
                    'defaults' => [
                        'controller' => 'Order\Controller\Ajax',
                        'action' => 'provideServersNotInCluster'
                    ]
                ]
            ],
        ]
    ],
    'controllers' => [
        'invokables' => [
            'MasterData\Controller\Index' => 'MasterData\Controller\IndexController'
        ],
        'factories' => [
            'MasterData\Controller\Server' => 'MasterData\Controller\Factory\ServerControllerFactory',
            'MasterData\Controller\Cluster' => 'MasterData\Controller\Factory\ClusterControllerFactory'
        ]
    ],
    'form_elements' => [
        'factories' => [
            // forms
            'MasterData\Form\ServerForm' => 'MasterData\Form\Factory\ServerFormFactory',
            'MasterData\Form\ClusterForm' => 'MasterData\Form\Factory\ClusterFormFactory',
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