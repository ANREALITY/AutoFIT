<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Form\Fieldset\EndpointFtgwSelfServiceTargetFieldset;
use DbSystel\DataObject\EndpointFtgwSelfService;
use Zend\ServiceManager\FactoryInterface;

class EndpointFtgwSelfServiceTargetFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EndpointFtgwSelfServiceTargetFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new EndpointFtgwSelfService();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
