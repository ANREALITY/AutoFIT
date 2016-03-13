<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\PhysicalConnectionCdFieldset;
use DbSystel\DataObject\FileTransferRequest;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhysicalConnectionCdFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new PhysicalConnectionCdFieldset();
        $hydrator = $serviceLocator->getServiceLocator()->get('HydratorManager')->get('DbSystel\Hydrator\PhysicalConnectionCdHydrator');
        $fieldset->setHydrator($hydrator);
        $prototype = new FileTransferRequest();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
