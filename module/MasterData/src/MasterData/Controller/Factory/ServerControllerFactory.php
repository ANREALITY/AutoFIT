<?php
namespace MasterData\Controller\Factory;

use MasterData\Controller\ServerController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\Server;

class ServerControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $serverService = $realServiceLocator->get('Order\Service\ServerService');

        $formElementManager = $realServiceLocator->get('FormElementManager');
        $serverForm = $formElementManager->get('MasterData\Form\ServerForm');

        $service = new ServerController(new Server(), $serverService);
        $service->setServerForm($serverForm);

        return $service;
    }

}