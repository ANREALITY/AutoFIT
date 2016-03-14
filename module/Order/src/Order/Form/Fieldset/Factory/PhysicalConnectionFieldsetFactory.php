<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\PhysicalConnectionFieldset;
use DbSystel\DataObject\PhysicalConnection;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhysicalConnectionFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new PhysicalConnectionFieldset();
        $hydrator = $serviceLocator->getServiceLocator()->get('HydratorManager')->get('DbSystel\Hydrator\PhysicalConnectionHydrator');
        $fieldset->setHydrator($hydrator);
        $prototype = new PhysicalConnection();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
