<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\EndpointCdTandem;
use Order\Form\Fieldset\EndpointCdTandemSourceFieldset;
use Zend\ServiceManager\FactoryInterface;

class EndpointCdTandemSourceFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EndpointCdTandemSourceFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new EndpointCdTandem();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
