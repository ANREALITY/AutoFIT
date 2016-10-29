<?php
return [
    'router' => [
        'routes' => [
            'list' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route' => '/audit-logging/list[/page/:page]',
                    'defaults' => [
                        'controller' => 'AuditLogging\Controller\Index',
                        'action' => 'list',
                        'page' => 1
                    ]
                ]
            ],
        ]
    ],
    'controllers' => [
        'invokables' => [],
        'factories' => [
            'AuditLogging\Controller\Index' => 'AuditLogging\Controller\Factory\IndexControllerFactory',
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
            // database request modifiers
            'AuditLogging\Mapper\RequestModifier\AuditLogRequestModifier' => 'AuditLogging\Mapper\RequestModifier\AuditLogRequestModifier',
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
