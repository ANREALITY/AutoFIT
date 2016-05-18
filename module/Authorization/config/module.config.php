<?php
return [
    'service_manager' => [
        'factories' => [
            'Acl' => 'Authorization\Acl\Factory\AclFactory',
            'Assertion\UserIsOwner' => 'Authorization\Acl\Assertion\Factory\UserIsOwnerFactory'
        ],
        'invokables' => []
    ]
];