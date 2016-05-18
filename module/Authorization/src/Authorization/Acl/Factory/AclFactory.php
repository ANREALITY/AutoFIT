<?php
namespace Authorization\Acl\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Authorization\Acl\Acl;

class AclFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $assertions = [
            'UserIsOwner' => $serviceLocator->get('Assertion\UserIsOwner')
        ];
        $routeMatch = $serviceLocator->get('Application')->getMvcEvent()->getRouteMatch();
        $routeMatchParams = $routeMatch->getParams();
        $service = new Acl($config, $assertions, $routeMatchParams);
        return $service;
    }
}
