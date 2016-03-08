<?php
namespace FileTransferRequest\Mapper\Factory;

use FileTransferRequest\Mapper\EndpointCdAs400Mapper;
use DbSystel\DataObject\EndpointCdAs400;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EndpointCdAs400MapperFactory implements FactoryInterface
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
        return new EndpointCdAs400Mapper($serviceLocator->get('Zend\Db\Adapter\Adapter'), $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\EndpointCdAs400Hydrator'), new EndpointCdAs400(), $serviceLocator->get('FileTransferRequest\Mapper\EndpointMapperInterface'));
    }
}
