<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Mapper\EndpointClusterConfigMapper;
use DbSystel\DataObject\EndpointClusterConfig;

class EndpointClusterConfigMapperFactory implements FactoryInterface
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
        $service = new EndpointClusterConfigMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new EndpointClusterConfig());

        $service->setClusterMapper($serviceLocator->get('Order\Mapper\ClusterMapper'));
        $service->setTableDataProcessor($serviceLocator->get('DbSystel\Utility\TableDataProcessor'));
        $service->setStringUtility($serviceLocator->get('DbSystel\Utility\StringUtility'));

        return $service;
    }

}
