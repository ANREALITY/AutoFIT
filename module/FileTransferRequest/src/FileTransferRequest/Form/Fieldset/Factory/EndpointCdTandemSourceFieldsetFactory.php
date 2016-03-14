<?php
namespace FileTransferRequest\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\EndpointCdTandem;
use FileTransferRequest\Form\Fieldset\EndpointCdTandemSourceFieldset;

class EndpointCdTandemSourceFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EndpointCdTandemSourceFieldset();
        $hydrator = $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\EndpointCdTandemHydrator');
        $fieldset->setHydrator($hydrator);
        $prototype = new EndpointCdTandem();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
