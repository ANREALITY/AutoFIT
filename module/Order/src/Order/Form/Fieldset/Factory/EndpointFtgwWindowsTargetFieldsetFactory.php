<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Form\Fieldset\EndpointFtgwWindowsTargetFieldset;
use DbSystel\DataObject\EndpointFtgwWindows;
use Zend\ServiceManager\FactoryInterface;

class EndpointFtgwWindowsTargetFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EndpointFtgwWindowsTargetFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new EndpointFtgwWindows();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
