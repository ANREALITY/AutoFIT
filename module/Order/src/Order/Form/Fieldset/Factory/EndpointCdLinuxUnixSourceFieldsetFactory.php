<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\EndpointCdLinuxUnix;
use Order\Form\Fieldset\EndpointCdLinuxUnixSourceFieldset;
use Zend\ServiceManager\FactoryInterface;

class EndpointCdLinuxUnixSourceFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EndpointCdLinuxUnixSourceFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new EndpointCdLinuxUnix();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
