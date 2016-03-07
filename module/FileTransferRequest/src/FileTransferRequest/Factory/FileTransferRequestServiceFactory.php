<?php
// Filename: /module/FileTransferRequest/src/FileTransferRequest/Factory/PostServiceFactory.php
namespace FileTransferRequest\Factory;

use FileTransferRequest\Service\FileTransferRequestService;
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
        return new FileTransferRequestService($serviceLocator->get('FileTransferRequest\Mapper\FileTransferRequestMapperInterface'));
    }
}