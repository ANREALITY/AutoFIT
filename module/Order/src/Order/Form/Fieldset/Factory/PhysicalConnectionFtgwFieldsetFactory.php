<?php
namespace Order\Form\Fieldset\Factory;

use Order\Form\Fieldset\PhysicalConnectionFtgwFieldset;
use DbSystel\DataObject\PhysicalConnectionFtgw;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhysicalConnectionFtgwFieldsetFactory extends AbstractPhysicalConnectionFieldsetFactory
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new PhysicalConnectionFtgwFieldset(null, [], 
            $this->detectProperEndpointSourceFieldsetServiceName($serviceLocator), 
            $this->detectProperEndpointTargetFieldsetServiceName($serviceLocator));
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new PhysicalConnectionFtgw();
        $fieldset->setObject($prototype);
        
        return $fieldset;
    }

}
