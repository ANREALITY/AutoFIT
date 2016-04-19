<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\NotificationFieldset;
use DbSystel\DataObject\Notification;
use Zend\ServiceManager\ServiceLocatorInterface;

class NotificationFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new NotificationFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new Notification();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
