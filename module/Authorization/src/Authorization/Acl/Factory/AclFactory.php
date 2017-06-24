<?php
namespace Authorization\Acl\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Authorization\Acl\Acl;

class AclFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $assertions = [
            'UserIsOwner' => $container->get('Assertion\UserIsOwner')
        ];
        $routeMatch = $container->get('Application')
            ->getMvcEvent()
            ->getRouteMatch();
        $routeMatchParams = $routeMatch->getParams();
        $service = new Acl($config, $assertions, $routeMatchParams);
        return $service;
    }

}
