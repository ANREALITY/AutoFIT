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
        'power-user' => [
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
        ],
    ],
    'service_manager' => [
        'factories' => [
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'power_user_navigation' => 'Base\Navigation\Service\PowerUserNavigationFactory',
            'admin_navigation' => 'Base\Navigation\Service\AdminNavigationFactory',
         ],
     ],
];
