<?php
namespace Authentication\Adapter\Factory;

use Authentication\Adapter\DbTable as AuthenticationAdapter;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class DbTableAuthenticationAdapterFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userService = $container->get('Order\Service\UserService');
        return new AuthenticationAdapter($userService);
    }

}
