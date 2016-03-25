<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\PhysicalConnectionCdFieldset;
use DbSystel\DataObject\PhysicalConnectionCd;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhysicalConnectionCdFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();

        $router = $realServiceLocator->get('router');
        $request = $realServiceLocator->get('request');
        $routerMatch = $router->match($request);

        $endpointSourceType = $routerMatch->getParam('endpointSourceType');
        $endpointSourceFieldsetServiceName = 'Order\Form\Fieldset\Endpoint' . $endpointSourceType . 'Source';
        $endpointTargetType = $routerMatch->getParam('endpointTargetType');
        $endpointTargetFieldsetServiceName = 'Order\Form\Fieldset\Endpoint' . $endpointTargetType . 'Target';

        $fieldset = new PhysicalConnectionCdFieldset(null, [], $endpointSourceFieldsetServiceName, $endpointTargetFieldsetServiceName);
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new PhysicalConnectionCd();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
