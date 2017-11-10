<?php
namespace Order\Controller\Factory;

use Order\Controller\AjaxController;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class AjaxControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $applicationService = $container->get('Order\Service\ApplicationService');
        $environmentService = $container->get('Order\Service\EnvironmentService');
        $serverService = $container->get('Order\Service\ServerService');
        $serviceInvoicePositionService = $container->get('Order\Service\ServiceInvoicePositionService');
        $clusterService = $container->get('Order\Service\ClusterService');
        $userService = $container->get('Order\Service\UserService');
        $fileTransferRequestService = $container->get('Order\Service\FileTransferRequestService');

        $service = new AjaxController(
            $applicationService,
            $environmentService,
            $serverService,
            $serviceInvoicePositionService,
            $clusterService,
            $userService,
            $fileTransferRequestService
        );

        return $service;
    }

}