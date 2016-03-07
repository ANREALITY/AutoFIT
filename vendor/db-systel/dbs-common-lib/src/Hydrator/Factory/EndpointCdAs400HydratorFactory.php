<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\Endpoint;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;

class EndpointCdAs400HydratorFactory implements FactoryInterface
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
        $endpointHydrator = $serviceLocator->get('DbSystel\Hydrator\EndpointHydrator');

        $endpointCdAs400Hydrator->addStrategy('endpoint', new GenericEntityStrategy($endpointHydrator, new Endpoint()));

        // no naming map

        return $endpointCdAs400Hydrator;
    }
}
