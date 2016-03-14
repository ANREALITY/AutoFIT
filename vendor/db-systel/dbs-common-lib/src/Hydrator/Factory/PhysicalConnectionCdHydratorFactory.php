<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\PhysicalConnection;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;
use DbSystel\DataObject\EndpointCdAs400;

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
        $physicalConnectionCdHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');
        $physicalConnectionHydrator = $serviceLocator->get('DbSystel\Hydrator\PhysicalConnectionHydrator');
        $endpointSourceHydrator = $serviceLocator->get('DbSystel\Hydrator\EndpointHydrator');
        $endpointTargetHydrator = $serviceLocator->get('DbSystel\Hydrator\EndpointHydrator');

        $physicalConnectionCdHydrator->addStrategy('physical_connection', new GenericEntityStrategy($physicalConnectionHydrator, new PhysicalConnection()));
        $physicalConnectionCdHydrator->addStrategy('endpoint_source', new GenericEntityStrategy($endpointSourceHydrator, new EndpointCdAs400()));
        $physicalConnectionCdHydrator->addStrategy('endpoint_target', new GenericEntityStrategy($endpointTargetHydrator, new EndpointCdAs400()));

        $namingStrategy = new MapNamingStrategy(array(
            'physical_connection' => 'physicalConnection',
            'secure_plus' => 'securePlus',
            'endpoint_source' => 'endpointSource',
            'endpoint_target' => 'endpointTarget',
        ));
        $physicalConnectionCdHydrator->setNamingStrategy($namingStrategy);

        return $physicalConnectionCdHydrator;
    }
}
