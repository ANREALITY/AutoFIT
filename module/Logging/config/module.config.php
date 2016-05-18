<?php
return [
    'service_manager' => [
        'factories' => [
            'Logging\Logger\ErrorLogger' => 'Logging\Logger\Factory\LoggerFactory'
        ]
    ]
];