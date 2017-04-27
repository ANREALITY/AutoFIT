<?php
namespace Authentication;

use Zend\Authentication\AuthenticationService;
use Authentication\Adapter\DbTable as AuthenticationAdapter;
use Zend\Authentication\Storage\Session;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/../../data/cache' . '/' . 'autoload_classmap.application.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                ]
            ]
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'AuthenticationStorage' => function ($serviceManager) {
                    return new Session('auth');
                },
                'AuthenticationService' => function ($serviceManager) {
                    $dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
                    $userService = $serviceManager->get('Order\Service\UserService');
                    if (! empty($_SERVER['AUTH_USER'])) {
                        $username = strrchr($_SERVER['AUTH_USER'], "\\") ? str_ireplace("\\", '',
                            strrchr($_SERVER['AUTH_USER'], "\\")) : $_SERVER['AUTH_USER'];
                    } else {
                        $username = 'undefined';
                    }
                    $authenticationAdapter = new AuthenticationAdapter($userService, $username);
                    $authenticationService = new AuthenticationService();
                    $authenticationService->setAdapter($authenticationAdapter);
                    $authenticationService->setStorage($serviceManager->get('AuthenticationStorage'));
                    $authenticationService->authenticate();

                    return $authenticationService;
                }
            ]
        ];
    }

}
