<?php
namespace Order\Controller\Factory;

use Order\Controller\AjaxController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AjaxControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $applicationService = $realServiceLocator->get('Order\Service\ApplicationService');
        $environmentService = $realServiceLocator->get('Order\Service\EnvironmentService');
        $serverService = $realServiceLocator->get('Order\Service\ServerService');
        $serviceInvoicePositionService = $realServiceLocator->get('Order\Service\ServiceInvoicePositionService');

        $service = new AjaxController($applicationService, $environmentService, $serverService,
            $serviceInvoicePositionService);

        return $service;
    }

}