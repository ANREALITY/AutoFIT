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
        'abstract_factories' => [
            // mappers
            // services
            'AuditLogging\Service\Factory\AbstractServiceFactory'
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ],
    ]
];
