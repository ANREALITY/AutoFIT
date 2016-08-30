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
                    'edit' => [
                        'admin' => 'UserIsOwner',
                        'member' => 'UserIsOwner'
                    ],
                    'cancel' => [
                        'admin' => 'UserIsOwner',
                        'member' => 'UserIsOwner'
                    ],
                    'accept' => 'admin',
                    'decline' => 'admin',
                    'complete' => 'admin',
                    'created' => 'member',
                    'edited' => 'member',
                    'canceled' => 'member',
                    'accepted' => 'admin',
                    'declined' => 'admin',
                    'completed' => 'admin',
                    'showOrder' => [
                        'admin' => null,
                        'member' => 'UserIsOwner'
                    ],
                    'listMyOrders' => 'member',
                    'syncInProgress' => 'member',
                    'operationDeniedForStatus' => 'member',
                    'listOrders' => 'admin',
                ],
                'Order\Controller\Ajax' => [
                    'all' => 'guest'
                ],
                'MasterData\Controller\Server' => [
                    'all' => 'member'
                ],
                'MasterData\Controller\Cluster' => [
                    'all' => 'member'
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
