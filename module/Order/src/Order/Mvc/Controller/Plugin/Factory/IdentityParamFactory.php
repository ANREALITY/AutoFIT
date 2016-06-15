<?php
namespace Order\Mvc\Controller\Plugin\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Mvc\Controller\Plugin\IdentityParam;

class IdentityParamFactory implements FactoryInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();

        $authenticationService = $realServiceLocator->get('AuthenticationService');

        return new IdentityParam($authenticationService);
    }

}
