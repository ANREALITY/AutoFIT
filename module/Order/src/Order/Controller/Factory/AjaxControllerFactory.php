<?php
namespace Order\Controller\Factory;

use Order\Controller\AjaxController;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class AjaxControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $realServiceLocator = $container->getServiceLocator();
        $applicationService = $realServiceLocator->get('Order\Service\ApplicationService');
        $environmentService = $realServiceLocator->get('Order\Service\EnvironmentService');
        $serverService = $realServiceLocator->get('Order\Service\ServerService');
        $serviceInvoicePositionService = $realServiceLocator->get('Order\Service\ServiceInvoicePositionService');
        $clusterService = $realServiceLocator->get('Order\Service\ClusterService');

        $service = new AjaxController($applicationService, $environmentService, $serverService,
            $serviceInvoicePositionService, $clusterService);

        return $service;
    }

}