<?php
return [
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
];
