<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\Endpoint;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;

class EndpointHydratorFactory implements FactoryInterface
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
        $endpointHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $endpointHydrator = $serviceLocator->get('DbSystel\Hydrator\EndpointCdHydrator');

        $endpointHydrator->addStrategy('endpoint', new GenericEntityStrategy($endpointHydrator, new Endpoint()));

        // no naming map

        return $endpointHydrator;
    }
}
