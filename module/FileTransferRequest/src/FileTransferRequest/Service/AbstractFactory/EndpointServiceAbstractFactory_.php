<?php
namespace FileTransferRequest\Service\Factory;

use FileTransferRequest\Service\EndpointService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EndpointServiceAbstractFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Abstract factory needed, since a concret EndpointMapper like EndpointCdAs400Mapper is needed!!!
        return new EndpointService($serviceLocator->get('FileTransferRequest\Mapper\EndpointMapperInterface'));
    }
}