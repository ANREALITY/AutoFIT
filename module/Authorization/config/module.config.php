<?php
return [
    'service_manager' => [
        'factories' => [
            'Acl' => 'Authorization\Acl\Factory\AclFactory'
        ],
        'invokables' => [],
    ]
];