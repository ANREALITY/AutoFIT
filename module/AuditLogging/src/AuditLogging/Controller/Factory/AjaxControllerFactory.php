<?php
namespace AuditLogging\Controller\Factory;

use AuditLogging\Controller\AjaxController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AjaxControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $userService = $realServiceLocator->get('Order\Service\UserService');
        $fileTransferRequestService = $realServiceLocator->get('Order\Service\FileTransferRequestService');

        $service = new AjaxController($userService, $fileTransferRequestService);

        return $service;
    }

}