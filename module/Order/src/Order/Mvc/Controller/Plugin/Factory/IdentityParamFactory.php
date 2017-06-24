<?php
namespace Order\Mvc\Controller\Plugin\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Order\Mvc\Controller\Plugin\IdentityParam;

class IdentityParamFactory implements FactoryInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see FactoryInterface::createService()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $realServiceLocator = $container->getServiceLocator();

        $authenticationService = $realServiceLocator->get('AuthenticationService');

        return new IdentityParam($authenticationService);
    }

}
