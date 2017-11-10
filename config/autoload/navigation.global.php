<?php
return [
    'navigation' => [
        'default' => [
            'home' => [
                'label' => _('home'),
                'route' => 'home',
            ],
            'list-my-orders' => [
                'label' => _('my orders'),
                'route' => 'list-my-orders',
            ],
            'master-data' => [
                'label' => _('master data'),
                'route' => 'master-data',
            ],
            [
                'label' => _('orders'),
                'route' => 'list-orders',
            ],
        ],
        'admin' => [
            [
                'label' => _('audit log'),
                'route' => 'audit-logging/list',
            ],
        ]
    ],
    'service_manager' => [
        'factories' => [
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'admin_navigation' => 'DbSystel\Navigation\Service\AdminNavigationFactory',
         ],
     ],
];
