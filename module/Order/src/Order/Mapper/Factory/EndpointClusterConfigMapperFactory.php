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
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $service = new EndpointClusterConfigMapper(
            $container->get('Zend\Db\Adapter\Adapter'),
            $container->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'),
            new EndpointClusterConfig(),
            null,
            $entityManager
        );

        $service->setTableDataProcessor($container->get('DbSystel\Utility\TableDataProcessor'));

        return $service;
    }

}
