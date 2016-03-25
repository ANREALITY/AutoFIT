<?php
namespace Order\Form\Fieldset\Factory;

use Order\Form\Fieldset\PhysicalConnectionCdFieldset;
use DbSystel\DataObject\PhysicalConnectionCd;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhysicalConnectionCdFieldsetFactory extends AbstractPhysicalConnectionFieldsetFactory
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new PhysicalConnectionCdFieldset(null, [], 
            $this->detectProperEndpointSourceFieldsetServiceName($serviceLocator), 
            $this->detectProperEndpointTargetFieldsetServiceName($serviceLocator));
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new PhysicalConnectionCd();
        $fieldset->setObject($prototype);
        
        return $fieldset;
    }

}
