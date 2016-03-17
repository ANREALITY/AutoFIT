<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\BasicEndpointCdTargetFieldset;
use DbSystel\DataObject\BasicEndpoint;
use Zend\ServiceManager\ServiceLocatorInterface;

class BasicEndpointCdTargetFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new BasicEndpointCdTargetFieldset();
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        // @todo make it generic!
        $prototype = new BasicEndpoint();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
