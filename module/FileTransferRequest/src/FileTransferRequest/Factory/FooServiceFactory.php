<?php
namespace FileTransferRequest\Factory;

use FileTransferRequest\Service\FooService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FooServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new FooService($serviceLocator->get('FileTransferRequest\Mapper\CustomerMapperInterface'));
    }
}