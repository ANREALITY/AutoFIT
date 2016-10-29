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
        ],
        'admin' => [
            [
                'label' => _('orders'),
                'route' => 'list-orders',
            ],
            [
                'label' => _('audit log'),
                'route' => 'list',
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
