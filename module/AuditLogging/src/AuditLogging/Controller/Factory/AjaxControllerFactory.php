<?php
namespace AuditLogging\Controller\Factory;

use AuditLogging\Controller\AjaxController;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class AjaxControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $realServiceLocator = $container->getServiceLocator();
        $userService = $realServiceLocator->get('Order\Service\UserService');
        $fileTransferRequestService = $realServiceLocator->get('Order\Service\FileTransferRequestService');

        $service = new AjaxController($userService, $fileTransferRequestService);

        return $service;
    }

}