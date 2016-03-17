<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\ApplicationFieldset;
use DbSystel\DataObject\Application;
use Zend\ServiceManager\ServiceLocatorInterface;

class ApplicationFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new ApplicationFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new Application();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
