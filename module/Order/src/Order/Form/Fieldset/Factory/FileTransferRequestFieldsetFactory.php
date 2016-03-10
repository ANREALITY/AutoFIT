<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\FileTransferRequestFieldset;
use DbSystel\DataObject\FileTransferRequest;
use Zend\ServiceManager\ServiceLocatorInterface;

class FileTransferRequestFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new FileTransferRequestFieldset();
        $hydrator = $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\FileTransferRequestHydrator');
        $fieldset->setHydrator($hydrator);
        $prototype = new FileTransferRequest();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
