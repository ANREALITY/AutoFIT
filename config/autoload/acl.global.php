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
                        'admin' => null,
                        'member' => 'UserIsOwner'
                    ],
                    'cancel' => [
                        'admin' => null,
                        'member' => 'UserIsOwner'
                    ],
                    'received' => 'member',
                    'updated' => 'member',
                    'canceled' => 'member',
                    'showOrder' => [
                        'admin' => null,
                        'member' => 'UserIsOwner'
                    ],
                    'listOrders' => 'member',
                    'syncInProgress' => 'member',
                    'operationDeniedForStatus' => 'member'
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
