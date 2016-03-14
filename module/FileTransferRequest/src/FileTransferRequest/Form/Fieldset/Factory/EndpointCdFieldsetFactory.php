<?php
namespace FileTransferRequest\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use FileTransferRequest\Form\Fieldset\EndpointCdFieldset;
use DbSystel\DataObject\EndpointCdAs400;
use Zend\ServiceManager\ServiceLocatorInterface;

class EndpointCdFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EndpointCdFieldset();
        $hydrator = $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\EndpointCdHydrator');
        $fieldset->setHydrator($hydrator);
        // @todo make it dynamic!
        $prototype = new EndpointCdAs400();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
