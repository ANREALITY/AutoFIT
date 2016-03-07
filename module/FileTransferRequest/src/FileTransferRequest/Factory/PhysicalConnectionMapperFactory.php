<?php
namespace FileTransferRequest\Factory;

use FileTransferRequest\Mapper\PhysicalConnectionMapper;
use DbSystel\DataObject\PhysicalConnection;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhysicalConnectionMapperFactory implements FactoryInterface
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
        return new PhysicalConnectionMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'), $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\PhysicalConnectionHydrator'), new PhysicalConnection());
    }
}
