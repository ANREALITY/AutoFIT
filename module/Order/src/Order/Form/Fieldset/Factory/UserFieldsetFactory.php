<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\UserFieldset;
use DbSystel\DataObject\User;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new UserFieldset();
        $hydrator = $serviceLocator->getServiceLocator()->get('HydratorManager')->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new User();
        $fieldset->setObject($prototype);
        
        return $fieldset;
    }
}
