<?php
return [
    'navigation' => [
        'default' => [
            'home' => [
                'label' => _('home'),
                'route' => 'home',
            ],
            'master-data' => [
                'label' => _('master data'),
                'route' => 'master-data',
            ],
            [
                'label' => _('orders'),
                'route' => 'order/list',
            ],
            [
                'label' => _('assignments'),
                'route' => 'ownership/list',
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
