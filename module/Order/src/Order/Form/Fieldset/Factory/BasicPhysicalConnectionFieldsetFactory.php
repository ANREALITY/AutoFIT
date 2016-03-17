<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\SpecificPhysicalConnectionCdFieldset;
use DbSystel\DataObject\BasicPhysicalConnection;
use Zend\ServiceManager\ServiceLocatorInterface;

class BasicPhysicalConnectionFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new SpecificPhysicalConnectionCdFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new BasicPhysicalConnection();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
