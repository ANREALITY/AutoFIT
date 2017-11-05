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
                    'show-overview' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/overview/show[/page/:page]',
                            'defaults' => [
                                'controller' => 'MasterData\Controller\Overview',
                                'action' => 'show',
                                'page' => 1
                            ]
                        ]
                    ],
                    'provide-servers' => [
                        'type' => 'Zend\Router\Http\Literal',
                        'options' => [
                            'route' => '/ajax/provide-servers',
                            'defaults' => [
                                'controller' => 'MasterData\Controller\Ajax',
                                'action' => 'provideServers'
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
            'MasterData\Controller\Cluster' => 'MasterData\Controller\Factory\ClusterControllerFactory',
            'MasterData\Controller\Overview' => 'MasterData\Controller\Factory\OverviewControllerFactory',
            'MasterData\Controller\Ajax' => 'MasterData\Controller\Factory\AjaxControllerFactory'
        ]
    ],
    'form_elements' => [
        'factories' => [
            // forms
            'MasterData\Form\ServerForm' => 'MasterData\Form\Factory\ServerFormFactory',
            'MasterData\Form\ClusterForm' => 'MasterData\Form\Factory\ClusterFormFactory',
            'MasterData\Form\SearchForm' => 'MasterData\Form\Factory\SearchFormFactory',
            // fieldsets
            'MasterData\Form\Fieldset\ServerAdditionalName' => 'MasterData\Form\Fieldset\Factory\ServerAdditionalNameFieldsetFactory',
            'MasterData\Form\Fieldset\Filter' => 'MasterData\Form\Fieldset\Factory\FilterFieldsetFactory'
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ],
        'strategies' => [
            'ViewJsonStrategy'
        ],
        'template_map' => [
            'pagination_overview' => __DIR__ . '/../view/partials/pagination.phtml',
        ]
    ],
];