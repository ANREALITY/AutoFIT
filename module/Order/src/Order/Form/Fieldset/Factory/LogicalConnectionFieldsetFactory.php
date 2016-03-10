<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\FileTransferRequestFieldset;
use DbSystel\DataObject\LogicalConnection;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogicalConnectionFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new FileTransferRequestFieldset();
        $hydrator = $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\LogicalConnectionHydrator');
        $fieldset->setHydrator($hydrator);
        $prototype = new LogicalConnection();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
