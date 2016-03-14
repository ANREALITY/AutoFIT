<?php
namespace FileTransferRequest\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use FileTransferRequest\Form\Fieldset\PhysicalConnectionCdFieldset;
use DbSystel\DataObject\PhysicalConnectionCd;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhysicalConnectionCdFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new PhysicalConnectionCdFieldset();
        $hydrator = $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\PhysicalConnectionCdHydrator');
        $fieldset->setHydrator($hydrator);
        $prototype = new PhysicalConnectionCd();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
