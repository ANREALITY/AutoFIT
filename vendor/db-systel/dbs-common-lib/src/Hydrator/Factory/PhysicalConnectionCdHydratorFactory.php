<?php
namespace DbSystel\Hydrator\Factory;

use Zend\Hydrator\NamingStrategy\MapNamingStrategy;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\AbstractPhysicalConnection;
use DbSystel\DataObject\EndpointCdAs400;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\Hydrator\Strategy\Entity\GenericCollectionStrategy;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;

class PhysicalConnectionCdHydratorFactory implements FactoryInterface
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
        $physicalConnectionHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $logicalConnectionHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $endpointHydrator = $serviceLocator->get('DbSystel\Hydrator\EndpointCdAs400Hydrator');
        $endpointSourceHydrator = $serviceLocator->get('DbSystel\Hydrator\EndpointCdAs400Hydrator');
        $endpointSourceHydrator = $serviceLocator->get('DbSystel\Hydrator\EndpointCdAs400Hydrator');
        
        $physicalConnectionHydrator->addStrategy('logical_connection', 
            new GenericEntityStrategy($logicalConnectionHydrator, new LogicalConnection()));
        // $endpointSourceHydrator->addStrategy('endpoints', new GenericCollectionStrategy($endpointHydrator, new EndpointCdAs400()));
        // @todo Make it dynamic!
        $physicalConnectionHydrator->addStrategy('endpoints', 
            new GenericCollectionStrategy($endpointHydrator, new EndpointCdAs400()));
        $physicalConnectionHydrator->addStrategy('endpoint_source', 
            new GenericEntityStrategy($endpointSourceHydrator, new EndpointCdAs400()));
        $physicalConnectionHydrator->addStrategy('endpoint_target', 
            new GenericEntityStrategy($endpointSourceHydrator, new EndpointCdAs400()));
        
        $namingStrategy = new MapNamingStrategy(
            array(
                'logical_connection' => 'logicalConnection',
                'endpoints' => 'endpoints',
                'endpoint_source' => 'endpointSource',
                'endpoint_target' => 'endpointTarget'
            ));
        $physicalConnectionHydrator->setNamingStrategy($namingStrategy);
        
        return $physicalConnectionHydrator;
    }
}
