<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\EndpointCdSourceFieldset;
use DbSystel\DataObject\Endpoint;
use Zend\ServiceManager\ServiceLocatorInterface;

class EndpointCdSourceFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EndpointCdSourceFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        // @todo make it dynamic!
        $prototype = new Endpoint();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
