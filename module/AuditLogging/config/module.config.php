<?php
return [
    'router' => [
        'routes' => [
            'audit-logging' => [
                'type' => 'Zend\Router\Http\Segment',
                'options' => [
                    'route' => '/audit-logging',
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'list' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/list[/page/:page]',
                            'defaults' => [
                                'controller' => 'AuditLogging\Controller\Index',
                                'action' => 'list',
                                'page' => 1
                            ]
                        ]
                    ],
                    'provide-users' => [
                        'type' => 'Zend\Router\Http\Literal',
                        'options' => [
                            'route' => '/ajax/provide-users',
                            'defaults' => [
                                'controller' => 'AuditLogging\Controller\Ajax',
                                'action' => 'provideUsers'
                            ]
                        ]
                    ],
                    'provide-file-transfer-requests' => [
                        'type' => 'Zend\Router\Http\Literal',
                        'options' => [
                            'route' => '/ajax/provide-file-transfer-requests',
                            'defaults' => [
                                'controller' => 'AuditLogging\Controller\Ajax',
                                'action' => 'provideFileTransferRequests'
                            ]
                        ]
                    ],
                ],
            ],
        ]
    ],
    'controllers' => [
        'invokables' => [],
        'factories' => [
            'AuditLogging\Controller\Index' => 'AuditLogging\Controller\Factory\IndexControllerFactory',
            'AuditLogging\Controller\Ajax' => 'AuditLogging\Controller\Factory\AjaxControllerFactory',
        ]
    ],
    'controller_plugins' => [
        'factories' => [
            'AuditLogger' => 'AuditLogging\Mvc\Controller\Plugin\Factory\AuditLoggerFactory',
        ]
    ],
    'service_manager' => [
        'factories' => [
            // services
            // mappers
            'AuditLogging\Mapper\AuditLogMapper' => 'AuditLogging\Mapper\Factory\AuditLogMapperFactory',
        ],
        'invokables' => [
            // utilities
        ],
        'abstract_factories' => [
            // mappers
            // services
            'AuditLogging\Service\Factory\AbstractServiceFactory'
        ]
    ],
    'form_elements' => [
        'invokables' => [
            // fieldsets
            'AuditLogging\Form\Fieldset\Filter' => 'AuditLogging\Form\Fieldset\FilterFieldset',
            'AuditLogging\Form\Fieldset\Sort' => 'AuditLogging\Form\Fieldset\SortFieldset',
        ],
        'factories' => [
            // forms
            'AuditLogging\Form\AuditLogForm' => 'AuditLogging\Form\Factory\AuditLogFormFactory',
            // fieldsets
            'AuditLogging\Form\Fieldset\Filter' => 'AuditLogging\Form\Fieldset\Factory\FilterFieldsetFactory',
            // 'AuditLogging\Form\Fieldset\Sort' => 'AuditLogging\Form\Fieldset\Factory\SortFieldsetFactory',
        ],
        'abstract_factories' => [
            // fieldsets
        ],
        'shared' => [
            'AuditLogging\Form\Fieldset\Filter' => false,
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ],
        'template_map' => [
            'pagination_audit_logging' => __DIR__ . '/../view/partials/pagination.phtml',
        ]
    ]
];
