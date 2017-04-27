<?php
$rootPath = __DIR__ . '/..';
return [
    'modules' => [
        'Logging',
        'ErrorHandling',
        'Authentication',
        'Authorization',
        'AuditLogging',
        'MasterData',
        'Order',
        'Application',
    ],
    'module_listener_options' => [
        'module_paths' => [
            $rootPath,
            $rootPath . '/module',
            $rootPath . '/vendor',
        ],
        'config_glob_paths' => [
            'config/autoload/test/{,*.}{global,local}.php',
        ],
        'config_cache_enabled' => false,
        'module_map_cache_enabled' => false,
    ],
];
