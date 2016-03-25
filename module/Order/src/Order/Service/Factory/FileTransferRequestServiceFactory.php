<?php
namespace Order\Service\Factory;

use Order\Service\FileTransferRequestService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FileTransferRequestServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new FileTransferRequestService($serviceLocator->get('Order\Mapper\FileTransferRequestMapper'));
    }

}