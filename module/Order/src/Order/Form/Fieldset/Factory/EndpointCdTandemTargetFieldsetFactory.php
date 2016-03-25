<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Form\Fieldset\EndpointCdTandemTargetFieldset;
use DbSystel\DataObject\EndpointCdTandem;
use Zend\ServiceManager\FactoryInterface;

class EndpointCdTandemTargetFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EndpointCdTandemTargetFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new EndpointCdTandem();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
