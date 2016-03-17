<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\PhysicalConnectionCdFieldset;
use DbSystel\DataObject\PhysicalConnection;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhysicalConnectionFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new PhysicalConnectionCdFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new PhysicalConnection();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
