<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\FileTransferRequestFieldset;
use DbSystel\DataObject\ServiceInvoicePosition;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceInvoicePositionBasicFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new FileTransferRequestFieldset();
        $hydrator = $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\ServiceInvoicePositionHydrator');
        $fieldset->setHydrator($hydrator);
        $prototype = new ServiceInvoicePosition();
        $fieldset->setObject($prototype);
        
        return $fieldset;
    }
}
