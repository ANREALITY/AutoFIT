<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Mapper\ClusterMapper;
use DbSystel\DataObject\Cluster;

class ClusterMapperFactory implements FactoryInterface
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
        $service = new ClusterMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'),
            new Cluster());

        $service->setServerMapper($serviceLocator->get('Order\Mapper\ServerMapper'));
        $service->setTableDataProcessor($serviceLocator->get('DbSystel\Utility\TableDataProcessor'));

        return $service;
    }

}
