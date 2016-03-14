<?php
namespace FileTransferRequest\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use FileTransferRequest\Form\Fieldset\EndpointCdSourceFieldset;
use DbSystel\DataObject\EndpointCdAs400;
use Zend\ServiceManager\ServiceLocatorInterface;

class EndpointCdSourceFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EndpointCdSourceFieldset();
        $hydrator = $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\EndpointCdTandemHydrator');
        $fieldset->setHydrator($hydrator);
        // @todo make it dynamic!
        $prototype = new EndpointCdAs400();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
