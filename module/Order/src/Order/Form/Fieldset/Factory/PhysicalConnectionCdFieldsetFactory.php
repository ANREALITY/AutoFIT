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
        $properServiceNameDetector = $serviceLocator->getServiceLocator()->get(
            'Order\Utility\ProperServiceNameDetector');
        $endpointSourceFieldsetServiceName = $properServiceNameDetector->getEndpointSourceFieldsetServiceName();
        $endpointTargetFieldsetServiceName = $properServiceNameDetector->getEndpointTargetFieldsetServiceName();
        
        $fieldset = new PhysicalConnectionCdFieldset(null, [], $endpointSourceFieldsetServiceName, 
            $endpointTargetFieldsetServiceName);
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new PhysicalConnectionCd();
        $fieldset->setObject($prototype);
        
        return $fieldset;
    }

}
