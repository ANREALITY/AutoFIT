<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Order\Mapper\EndpointClusterConfigMapper;
use DbSystel\DataObject\EndpointClusterConfig;

class EndpointClusterConfigMapperFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ContainerInterface $container
     *
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = new EndpointClusterConfigMapper($container->get('Zend\Db\Adapter\Adapter'),
            $container->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new EndpointClusterConfig());

        $service->setClusterMapper($container->get('Order\Mapper\ClusterMapper'));
        $service->setTableDataProcessor($container->get('DbSystel\Utility\TableDataProcessor'));
        $service->setStringUtility($container->get('DbSystel\Utility\StringUtility'));

        return $service;
    }

}
