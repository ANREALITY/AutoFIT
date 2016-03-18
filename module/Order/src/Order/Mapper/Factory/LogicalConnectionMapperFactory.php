<?php
namespace Order\Mapper\Factory;

use Order\Mapper\LogicalConnectionMapper;
use DbSystel\DataObject\LogicalConnection;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogicalConnectionMapperFactory implements FactoryInterface
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
        return new LogicalConnectionMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\LogicalConnectionHydrator'),
            new LogicalConnection(), $serviceLocator->get('Order\Mapper\SpecificPhysicalConnectionCdMapper'));
    }
}