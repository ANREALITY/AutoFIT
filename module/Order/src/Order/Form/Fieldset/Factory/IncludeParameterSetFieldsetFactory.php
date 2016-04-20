<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\IncludeParameterSetFieldset;
use DbSystel\DataObject\IncludeParameterSet;
use Zend\ServiceManager\ServiceLocatorInterface;

class IncludeParameterSetFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new IncludeParameterSetFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new IncludeParameterSet();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
