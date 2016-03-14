<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\EndpointCdFieldset;
use DbSystel\DataObject\EndpointCdAs400;
use Zend\ServiceManager\ServiceLocatorInterface;

class EndpointCdFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EndpointCdFieldset();
        $hydrator = $serviceLocator->getServiceLocator()->get('HydratorManager')->get('DbSystel\Hydrator\EndpointCdHydrator');
        $fieldset->setHydrator($hydrator);
        // @todo make it dynamic!
        $prototype = new EndpointCdAs400();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
