<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\ServiceInvoicePositionPersonalFieldset;
use DbSystel\DataObject\ServiceInvoicePosition;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceInvoicePositionPersonalFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new ServiceInvoicePositionPersonalFieldset();
        $hydrator = $serviceLocator->getServiceLocator()->get('HydratorManager')->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new ServiceInvoicePosition();
        $fieldset->setObject($prototype);
        
        return $fieldset;
    }
}
