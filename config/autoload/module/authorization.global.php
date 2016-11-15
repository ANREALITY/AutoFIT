<?php
return [
    'acl' => [
        'roles' => [
            'guest' => null,
            'member' => 'guest',
            'admin' => 'member'
        ],
        'resources' => [
            'allow' => [
                'Application\Controller\Index' => [
                    'all' => 'guest'
                ],
                'Application\Controller\Error' => [
                    'all' => 'guest'
                ],
                'Order\Controller\Process' => [
                    'index' => 'member',
                    'start' => 'member',
                    'create' => 'member',
                    'startEditing' => [
                        'admin' => 'UserIsOwner',
                        'member' => 'UserIsOwner'
                    ],
                    'edit' => [
                        'admin' => 'UserIsOwner',
                        'member' => 'UserIsOwner'
                    ],
                    'submit' => [
                        'admin' => 'UserIsOwner',
                        'member' => 'UserIsOwner'
                    ],
                    'cancel' => [
                        'admin' => 'UserIsOwner',
                        'member' => 'UserIsOwner'
                    ],
                    'accept' => 'admin',
                    'decline' => 'admin',
                    'startChecking' => 'admin',
                    'complete' => 'admin',
                    'created' => 'member',
                    'checkingStarted' => 'member',
                    'edited' => 'member',
                    'canceled' => 'member',
                    'accepted' => 'admin',
                    'declined' => 'admin',
                    'checkingStarted' => 'admin',
                    'completed' => 'admin',
                    'showOrder' => [
                        'admin' => null,
                        'member' => 'UserIsOwner'
                    ],
                    'exportOrder' => 'admin',
                    'listMyOrders' => 'member',
                    'syncInProgress' => 'member',
                    'operationDeniedForStatus' => 'member',
                    'listOrders' => 'admin',
                ],
                'Order\Controller\Ajax' => [
                    'all' => 'guest'
                ],
                'MasterData\Controller\Index' => [
                    'all' => 'member'
                ],
                'MasterData\Controller\Server' => [
                    'all' => 'member'
                ],
                'MasterData\Controller\Cluster' => [
                    'all' => 'member'
                ],
                'AuditLogging\Controller\Index' => [
                    'all' => 'admin'
                ],
                'AuditLogging\Controller\Ajax' => [
                    'all' => 'admin'
                ],
            ]
        ],
        'redirect_route' => [
            'params' => [],
            'options' => [
                'name' => 'error403'
            ]
        ]
    ]
];
