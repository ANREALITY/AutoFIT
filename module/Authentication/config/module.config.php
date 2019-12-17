<?php
namespace Authentication;

use Application\Controller\IndexController;
use Authentication\Adapter\DbTable as DbTableAuthenticationAdapter;
use Authentication\Adapter\Factory\DbTableAuthenticationAdapterFactory;
use Authentication\Authentication\Controller\Factory\AuthControllerFactory;
use Authentication\Controller\AuthController;
use Authentication\Service\AuthManager;
use Authentication\Service\Factory\AuthenticationServiceFactory;
use Authentication\Service\Factory\AuthManagerFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Authentication\AuthenticationService;
use Zend\Router\Http\Literal;
use Zend\Session\Service\SessionManagerFactory;
use Zend\Session\SessionManager;

return [
    'router' => [
        'routes' => [
            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action' => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action' => 'logout',
                    ],
                ],
            ],
            'change-identity' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/change-identity',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action' => 'changeIdentity',
                    ],
                ],
            ],
            'identity-changed' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/identity-changed',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action' => 'identityChanged',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            AuthController::class => AuthControllerFactory::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
//            Controller\Plugin\CurrentUserPlugin::class => Controller\Plugin\Factory\CurrentUserPluginFactory::class,
        ],
        'aliases' => [
//            'currentUser' => Controller\Plugin\CurrentUserPlugin::class,
        ],
    ],
    // The 'access_filter' key is used by the User module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
    'access_filter' => [
        // @see /config/authentication.global.php
    ],
    'service_manager' => [
        'factories' => [
            // services
            'AuthenticationService' => AuthenticationServiceFactory::class,
            DbTableAuthenticationAdapter::class => DbTableAuthenticationAdapterFactory::class,
            AuthManager::class => AuthManagerFactory::class,
            SessionManager::class => SessionManagerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    // We register module-provided view helpers under this key.
    'view_helpers' => [
        'factories' => [
//            View\Helper\CurrentUser::class => View\Helper\Factory\CurrentUserFactory::class,
        ],
        'aliases' => [
//            'currentUser' => View\Helper\CurrentUser::class,
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
];
