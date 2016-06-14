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
                    'created' => 'member',
                    'edited' => 'member',
                    'canceled' => 'member',
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
