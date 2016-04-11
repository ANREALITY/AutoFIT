<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\EndpointFtgwWindows;
use Order\Form\Fieldset\EndpointFtgwWindowsSourceFieldset;
use Zend\ServiceManager\FactoryInterface;

class EndpointFtgwWindowsSourceFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EndpointFtgwWindowsSourceFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new EndpointFtgwWindows();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
