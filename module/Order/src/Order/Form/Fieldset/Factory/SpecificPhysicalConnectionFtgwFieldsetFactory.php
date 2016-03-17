<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\SpecificPhysicalConnectionFtgwFieldset;
use DbSystel\DataObject\SpecificPhysicalConnectionFtgw;
use Zend\ServiceManager\ServiceLocatorInterface;

class SpecificPhysicalConnectionFtgwFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new SpecificPhysicalConnectionFtgwFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new SpecificPhysicalConnectionFtgw();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
