<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\PhysicalConnectionFtgwFieldset;
use DbSystel\DataObject\PhysicalConnectionFtgw;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhysicalConnectionFtgwFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $properServiceNameDetector = $serviceLocator->getServiceLocator()->get(
            'Order\Utility\ProperServiceNameDetector');
        $endpointSourceFieldsetServiceName = $properServiceNameDetector->getEndpointSourceFieldsetServiceName();
        $endpointTargetFieldsetServiceName = $properServiceNameDetector->getEndpointTargetFieldsetServiceName();

        $fieldset = new PhysicalConnectionFtgwFieldset(null, [], $endpointSourceFieldsetServiceName,
            $endpointTargetFieldsetServiceName);
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new PhysicalConnectionFtgw();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
