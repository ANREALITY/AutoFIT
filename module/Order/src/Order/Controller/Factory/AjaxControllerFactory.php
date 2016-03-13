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

        return new AjaxController($applicationService);
    }
}