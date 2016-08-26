<?php
namespace MasterData\Controller\Factory;

use MasterData\Controller\ServerController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServerControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $serverService = $realServiceLocator->get('Order\Service\ServerService');

        $service = new ServerController($serverService);

        return $service;
    }

}