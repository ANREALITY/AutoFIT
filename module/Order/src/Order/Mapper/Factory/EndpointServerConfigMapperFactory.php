<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Mapper\EndpointServerConfigMapper;
use DbSystel\DataObject\EndpointServerConfig;

class EndpointServerConfigMapperFactory implements FactoryInterface
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
        $service = new EndpointServerConfigMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new EndpointServerConfig());

        $service->setServerMapper($serviceLocator->get('Order\Mapper\ServerMapper'));
        $service->setTableDataProcessor($serviceLocator->get('DbSystel\Utility\TableDataProcessor'));

        return $service;
    }

}
