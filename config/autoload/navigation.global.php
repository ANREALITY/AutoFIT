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
            'order/list-own' => [
                'label' => _('my orders'),
                'route' => 'order/list-own',
            ],
        ],
        'admin' => [
            [
                'label' => _('orders'),
                'route' => 'order/list',
            ],
            [
                'label' => _('audit log'),
                'route' => 'audit-logging/list',
            ],
        ]
    ],
    'service_manager' => [
        'factories' => [
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'admin_navigation' => 'Base\Navigation\Service\AdminNavigationFactory',
         ],
     ],
];
