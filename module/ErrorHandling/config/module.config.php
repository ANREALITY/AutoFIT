<?php
return [
    'service_manager' => [
        'invokables' => [],
        'factories' => [
            'ErrorHandling\Handler\ErrorHandler' => 'ErrorHandling\Handler\Factory\ErrorHandlerFactory',
            'ErrorHandling\Handler\ExceptionHandler' => 'ErrorHandling\Handler\Factory\ExceptionHandlerFactory',
            'ErrorHandling\Handler\WarningHandler' => 'ErrorHandling\Handler\Factory\WarningHandlerFactory',
        ]
    ]
];
