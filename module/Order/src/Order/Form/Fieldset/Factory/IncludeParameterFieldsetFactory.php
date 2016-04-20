<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\IncludeParameterFieldset;
use DbSystel\DataObject\IncludeParameter;
use Zend\ServiceManager\ServiceLocatorInterface;

class IncludeParameterFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new IncludeParameterFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new IncludeParameter();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
