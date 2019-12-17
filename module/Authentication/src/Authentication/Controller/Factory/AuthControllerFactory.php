<?php
namespace Authentication\Authentication\Controller\Factory;

use Interop\Container\ContainerInterface;
use Authentication\Controller\AuthController;
use Authentication\Service\AuthManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authenticationService = $container->get('AuthenticationService');
        $authManager = $container->get(AuthManager::class);
        return new AuthController($authenticationService, $authManager);
    }

}
