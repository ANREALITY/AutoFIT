<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;
use DbSystel\Hydrator\Strategy\Entity\GenericCollectionStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;
use DbSystel\DataObject\SpecificEndpointCdAs400;

class BasicPhysicalConnectionHydratorFactory implements FactoryInterface
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
        $basicPhysicalConnectionHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $logicalConnectionHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $specificEndpointHydrator = $serviceLocator->get('DbSystel\Hydrator\SpecificEndpointCdAs400Hydrator');
        $basicEndpointSourceHydrator = $serviceLocator->get('DbSystel\Hydrator\BasicEndpointHydrator');
        $basicEndpointSourceHydrator = $serviceLocator->get('DbSystel\Hydrator\BasicEndpointHydrator');

        $basicPhysicalConnectionHydrator->addStrategy('logical_connection',
            new GenericEntityStrategy($logicalConnectionHydrator, new LogicalConnection())); // @todo AbstractFactory needed!!!
                                                                                                                                                                 // $basicPhysicalConnectionHydrator->addStrategy('specific_endpoints', new GenericCollectionStrategy($specificEndpointHydrator, new AbstractBasicEndpoint()));
        $basicPhysicalConnectionHydrator->addStrategy('specific_endpoints',
            new GenericCollectionStrategy($specificEndpointHydrator, new SpecificEndpointCdAs400()));
        $basicPhysicalConnectionHydrator->addStrategy('specific_endpoint_source',
            new GenericEntityStrategy($basicEndpointSourceHydrator, new SpecificEndpointCdAs400()));
        $basicPhysicalConnectionHydrator->addStrategy('specific_endpoint_target',
            new GenericEntityStrategy($basicEndpointSourceHydrator, new SpecificEndpointCdAs400()));

        $namingStrategy = new MapNamingStrategy(
            array(
                'logical_connection' => 'logicalConnection',
                'specific_endpoints' => 'specificEndpoints',
                'specific_endpoint_source' => 'specificEndpointSource',
                'specific_endpoint_target' => 'specificEndpointTarget'
            ));
        $basicPhysicalConnectionHydrator->setNamingStrategy($namingStrategy);

        return $basicPhysicalConnectionHydrator;
    }
}
