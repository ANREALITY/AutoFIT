<?php
namespace Order\Controller\Factory;

use Interop\Container\ContainerInterface;
use Order\Controller\OwnershipController;
use Order\Service\FileTransferRequestServiceInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class OwnershipControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var FileTransferRequestServiceInterface $fileTransferRequestService */
        $fileTransferRequestService = $container->get('Order\Service\FileTransferRequestService');
        $service = new OwnershipController($fileTransferRequestService);

        return $service;
    }

}
