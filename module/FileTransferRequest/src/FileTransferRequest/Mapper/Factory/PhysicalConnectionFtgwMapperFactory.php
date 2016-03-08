<?php
namespace FileTransferRequest\Mapper\Factory;

use FileTransferRequest\Mapper\PhysicalConnectionCdMapper;
use DbSystel\DataObject\PhysicalConnectionFtgw;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhysicalConnectionCdMapperFactory implements FactoryInterface
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
        return new PhysicalConnectionCdMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'), $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\PhysicalConnectionHydrator'), new PhysicalConnectionFtgw(), $serviceLocator->get('FileTransferRequest\Mapper\PhysicalConnectionMapperInterface'));
    }
}
