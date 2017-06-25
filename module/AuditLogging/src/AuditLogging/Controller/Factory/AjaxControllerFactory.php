<?php
namespace AuditLogging\Controller\Factory;

use AuditLogging\Controller\AjaxController;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class AjaxControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userService = $container->get('Order\Service\UserService');
        $fileTransferRequestService = $container->get('Order\Service\FileTransferRequestService');

        $service = new AjaxController($userService, $fileTransferRequestService);

        return $service;
    }

}