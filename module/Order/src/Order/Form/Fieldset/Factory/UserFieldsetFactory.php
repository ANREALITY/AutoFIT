<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\FileTransferRequestFieldset;
use DbSystel\DataObject\User;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new FileTransferRequestFieldset();
        $hydrator = $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\UserHydrator');
        $fieldset->setHydrator($hydrator);
        $prototype = new User();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
