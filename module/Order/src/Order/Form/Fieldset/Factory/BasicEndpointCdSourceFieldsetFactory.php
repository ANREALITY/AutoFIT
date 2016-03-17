<?php
namespace Order\Form\Fieldset\Factory;

use Order\Form\Fieldset\BasicEndpointCdSourceFieldset;
use DbSystel\DataObject\BasicEndpoint;
use Zend\ServiceManager\ServiceLocatorInterface;

class BasicEndpointCdSourceFieldsetFactory extends AbstractBasicEndpointCdFieldsetFactory
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new BasicEndpointCdSourceFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        // @todo make it dynamic!
        $prototype = new BasicEndpoint();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
