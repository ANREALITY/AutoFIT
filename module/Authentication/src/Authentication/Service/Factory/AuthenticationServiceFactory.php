<?php
namespace Authentication\Service\Factory;

use Authentication\Adapter\DbTable as DbTableAuthenticationAdapter;
use Authentication\Authentication\Service\AuthenticationService;
use Interop\Container\ContainerInterface;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\SessionManager;

class AuthenticationServiceFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $sessionManager = $container->get(SessionManager::class);
        $authenticationStorage = new SessionStorage('auth', 'session', $sessionManager);
        $authenticationAdapter = $container->get(DbTableAuthenticationAdapter::class);

        return new AuthenticationService($authenticationStorage, $authenticationAdapter);
    }

}
