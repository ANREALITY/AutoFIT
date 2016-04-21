<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Form\Fieldset\EndpointCdLinuxUnixTargetFieldset;
use DbSystel\DataObject\EndpointCdLinuxUnix;
use Zend\ServiceManager\FactoryInterface;

class EndpointCdLinuxUnixTargetFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EndpointCdLinuxUnixTargetFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new EndpointCdLinuxUnix();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
