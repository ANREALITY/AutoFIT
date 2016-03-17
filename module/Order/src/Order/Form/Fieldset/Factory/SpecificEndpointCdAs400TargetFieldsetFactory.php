<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Form\Fieldset\SpecificEndpointCdAs400TargetFieldset;
use DbSystel\DataObject\SpecificEndpointCdAs400;

class SpecificEndpointCdAs400TargetFieldsetFactory extends AbstractSpecificEndpointCdAs400FieldsetFactory
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new SpecificEndpointCdAs400TargetFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new SpecificEndpointCdAs400();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
