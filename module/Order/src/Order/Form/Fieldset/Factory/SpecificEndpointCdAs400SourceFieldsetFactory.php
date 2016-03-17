<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\SpecificEndpointCdAs400;
use Order\Form\Fieldset\SpecificEndpointCdAs400SourceFieldset;

class SpecificEndpointCdAs400SourceFieldsetFactory extends AbstractSpecificEndpointCdAs400FieldsetFactory
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new SpecificEndpointCdAs400SourceFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new SpecificEndpointCdAs400();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
