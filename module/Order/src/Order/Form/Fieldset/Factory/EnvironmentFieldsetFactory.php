<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\EnvironmentFieldset;
use DbSystel\DataObject\Environment;
use Zend\ServiceManager\ServiceLocatorInterface;

class EnvironmentFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EnvironmentFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new Environment();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
