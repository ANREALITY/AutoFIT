<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\EndpointCdFieldset;
use DbSystel\DataObject\Endpoint;
use Zend\ServiceManager\ServiceLocatorInterface;

class EndpointCdFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fieldset = new EndpointCdFieldset();
        $hydrator = $serviceLocator->getServiceLocator()->get('HydratorManager')->get('DbSystel\Hydrator\EndpointCdHydrator');
        $fieldset->setHydrator($hydrator);
        // @todo make it dynamic!
        $prototype = new Endpoint();
        $fieldset->setObject($prototype);

        return $fieldset;
    }
}
