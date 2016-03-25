<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\CustomerFieldset;
use DbSystel\DataObject\Customer;
use Zend\ServiceManager\ServiceLocatorInterface;

class CustomerFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new CustomerFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new Customer();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
