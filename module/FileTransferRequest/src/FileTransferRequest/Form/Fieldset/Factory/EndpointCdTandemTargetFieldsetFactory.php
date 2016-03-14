<?php
namespace FileTransferRequest\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use FileTransferRequest\Form\Fieldset\EndpointCdTandemTargetFieldset;
use DbSystel\DataObject\EndpointCdTandem;

class EndpointCdTandemTargetFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EndpointCdTandemTargetFieldset();
        $hydrator = $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\EndpointCdTandemHydrator');
        $fieldset->setHydrator($hydrator);
        $prototype = new EndpointCdTandem();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
