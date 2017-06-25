<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Order\Mapper\EndpointServerConfigMapper;
use DbSystel\DataObject\EndpointServerConfig;

class EndpointServerConfigMapperFactory implements FactoryInterface
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
        $service = new EndpointServerConfigMapper($container->get('Zend\Db\Adapter\Adapter'),
            $container->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new EndpointServerConfig());

        $service->setServerMapper($container->get('Order\Mapper\ServerMapper'));
        $service->setTableDataProcessor($container->get('DbSystel\Utility\TableDataProcessor'));
        $service->setStringUtility($container->get('DbSystel\Utility\StringUtility'));

        return $service;
    }

}
