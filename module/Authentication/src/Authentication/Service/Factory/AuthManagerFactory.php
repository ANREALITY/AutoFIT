<?php
namespace Authentication\Service\Factory;

use Interop\Container\ContainerInterface;
use Authentication\Service\AuthManager;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\SessionManager;

class AuthManagerFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authenticationService = $container->get('AuthenticationService');
        $sessionManager = $container->get(SessionManager::class);
        $userService = $container->get('Order\Service\UserService');
        $config = isset($container->get('config')['access_filter'])
            ? $container->get('config')['access_filter']
            : []
        ;

        return new AuthManager($authenticationService, $sessionManager, $userService, $config);
    }

}
