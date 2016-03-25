<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractPhysicalConnectionFieldsetFactory implements FactoryInterface
{

    abstract public function createService(ServiceLocatorInterface $serviceLocator);

    protected function detectProperEndpointSourceFieldsetServiceName(ServiceLocatorInterface $serviceLocator)
    {
        $routerMatch = $this->getRouteMatch($serviceLocator);

        $endpointSourceType = $routerMatch->getParam('endpointSourceType');
        $endpointSourceFieldsetServiceName = 'Order\Form\Fieldset\Endpoint' . $endpointSourceType . 'Source';
        
        return $endpointSourceFieldsetServiceName;
    }

    protected function detectProperEndpointTargetFieldsetServiceName(ServiceLocatorInterface $serviceLocator)
    {
        $routerMatch = $this->getRouteMatch($serviceLocator);

        $endpointTargetType = $routerMatch->getParam('endpointTargetType');
        $endpointTargetFieldsetServiceName = 'Order\Form\Fieldset\Endpoint' . $endpointTargetType . 'Target';

        return $endpointTargetFieldsetServiceName;
    }

    protected function getRouteMatch(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();

        $router = $realServiceLocator->get('router');
        $request = $realServiceLocator->get('request');
        $routerMatch = $router->match($request);

        return $routerMatch;
    }

}
