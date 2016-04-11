<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\EndpointFtgwSelfService;
use Order\Form\Fieldset\EndpointFtgwSelfServiceSourceFieldset;
use Zend\ServiceManager\FactoryInterface;

class EndpointFtgwSelfServiceSourceFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EndpointFtgwSelfServiceSourceFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new EndpointFtgwSelfService();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
