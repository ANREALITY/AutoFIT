<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\Endpoint;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;

class EndpointCdTandemHydratorFactory implements FactoryInterface
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
        $endpointCdTandemHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $endpointHydrator = $serviceLocator->get('DbSystel\Hydrator\EndpointHydrator');

        $endpointCdTandemHydrator->addStrategy('endpoint', new GenericEntityStrategy($endpointHydrator, new Endpoint()));

        // no naming map

        return $endpointCdTandemHydrator;
    }
}
