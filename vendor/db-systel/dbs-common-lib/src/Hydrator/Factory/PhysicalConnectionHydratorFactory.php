<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;
use DbSystel\Hydrator\Strategy\Entity\GenericCollectionStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;
use DbSystel\DataObject\Endpoint;

class PhysicalConnectionHydratorFactory implements FactoryInterface
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
        $endpointHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');

        $physicalConnectionHydrator->addStrategy('logical_connection', new GenericEntityStrategy($logicalConnectionHydrator, new LogicalConnection()));        // @todo AbstractFactory needed!!!
        // $physicalConnectionHydrator->addStrategy('endpoints', new GenericCollectionStrategy($endpointHydrator, new AbstractEndpoint()));
        // $physicalConnectionHydrator->addStrategy('endpoints', new GenericCollectionStrategy($endpointHydrator, new EndpointCdTandem()));
        $physicalConnectionHydrator->addStrategy('endpoints', new GenericCollectionStrategy($endpointHydrator, new Endpoint()));

        $namingStrategy = new MapNamingStrategy(array(
            'logical_connection' => 'logicalConnection',
        ));
        $physicalConnectionHydrator->setNamingStrategy($namingStrategy);

        return $physicalConnectionHydrator;
    }
}
