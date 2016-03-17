<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\BasicEndpoint;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;

class SpecificEndpointCdAs400HydratorFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $endpointCdAs400Hydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $basicEndpointHydrator = $serviceLocator->get('DbSystel\Hydrator\BasicEndpointCdHydrator');

        $endpointCdAs400Hydrator->addStrategy('basic_endpoint', new GenericEntityStrategy($basicEndpointHydrator, new BasicEndpoint()));

        // no naming map

        return $endpointCdAs400Hydrator;
    }
}
