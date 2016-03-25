<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\ServiceInvoicePositionBasicFieldset;
use DbSystel\DataObject\ServiceInvoicePosition;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceInvoicePositionBasicFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new ServiceInvoicePositionBasicFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new ServiceInvoicePosition();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
