<?php
namespace Order\Mapper\Factory;

use Order\Mapper\LogicalConnectionCdMapper;
use DbSystel\DataObject\LogicalConnection;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogicalConnectionCdMapperFactory implements FactoryInterface
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
        $service = new LogicalConnectionCdMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new LogicalConnection());

        $properServiceNameDetector = $serviceLocator->get('Order\Utility\ProperServiceNameDetector');
        $physicalConnectionMapperServiceName = $properServiceNameDetector->getPhysicalConnectionMapperServiceName();

        $service->setPhysicalConnectionMapper($serviceLocator->get($physicalConnectionMapperServiceName));

        return $service;
    }

}