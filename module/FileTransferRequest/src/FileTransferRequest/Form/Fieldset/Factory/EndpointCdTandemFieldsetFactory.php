<?php
namespace FileTransferRequest\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use FileTransferRequest\Form\Fieldset\EndpointCdTandemFieldset;
use DbSystel\DataObject\EndpointCdTandem;
use Zend\ServiceManager\ServiceLocatorInterface;

class EndpointCdTandemFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EndpointCdTandemFieldset();
        $hydrator = $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\EndpointCdTandemHydrator');
        $fieldset->setHydrator($hydrator);
        $prototype = new EndpointCdTandem();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
