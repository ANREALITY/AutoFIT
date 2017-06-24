<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Order\Mapper\EndpointMapper;

class EndpointMapperFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = new EndpointMapper($container->get('Zend\Db\Adapter\Adapter'),
            $container->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'));

        $service->setServerMapper($container->get('Order\Mapper\ServerMapper'));
        $service->setEndpointServerConfigMapper($container->get('Order\Mapper\EndpointServerConfigMapper'));
        $service->setExternalServerMapper($container->get('Order\Mapper\ExternalServerMapper'));
        $service->setApplicationMapper($container->get('Order\Mapper\ApplicationMapper'));
        $service->setCustomerMapper($container->get('Order\Mapper\CustomerMapper'));
        $service->setIncludeParameterSetMapper($container->get('Order\Mapper\IncludeParameterSetMapper'));
        $service->setProtocolSetMapper($container->get('Order\Mapper\ProtocolSetMapper'));
        $service->setFileParameterSetMapper($container->get('Order\Mapper\FileParameterSetMapper'));
        $service->setAccessConfigSetMapper($container->get('Order\Mapper\AccessConfigSetMapper'));
        $service->setProtocolMapper($container->get('Order\Mapper\ProtocolMapper'));
        $service->setClusterMapper($container->get('Order\Mapper\ClusterMapper'));
        $service->setEndpointClusterConfigMapper($container->get('Order\Mapper\EndpointClusterConfigMapper'));
        $service->setTableDataProcessor($container->get('DbSystel\Utility\TableDataProcessor'));
        $service->setStringUtility($container->get('DbSystel\Utility\StringUtility'));

        return $service;
    }

}
