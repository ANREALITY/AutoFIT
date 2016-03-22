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
        // @todo make it dynamic!
        $connectionType = LogicalConnection::TYPE_CD;
        if ($connectionType === LogicalConnection::TYPE_CD) {
            $physicalConnectionMapperServiceName = 'Order\Mapper\PhysicalConnectionCdMapper';
        } elseif ($connectionType === LogicalConnection::TYPE_FTGW) {
            $physicalConnectionMapperServiceName = 'Order\Mapper\PhysicalConnectionFtgwMapper';
        }

        return new LogicalConnectionMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'),
            new LogicalConnection(), $serviceLocator->get($physicalConnectionMapperServiceName));
    }
}