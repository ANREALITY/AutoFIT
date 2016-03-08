<?php
namespace FileTransferRequest\Mapper\Factory;

use FileTransferRequest\Mapper\EndpointCdTandemMapper;
use DbSystel\DataObject\EndpointCdTandem;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EndpointCdTandemMapperFactory implements FactoryInterface
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
        return new EndpointCdTandemMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'), $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\EndpointCdTandemHydrator'), new EndpointCdTandem(), $serviceLocator->get('FileTransferRequest\Mapper\EndpointMapperInterface'));
    }
}
