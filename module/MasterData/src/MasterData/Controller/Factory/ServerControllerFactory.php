<?php
namespace MasterData\Controller\Factory;

use MasterData\Controller\ServerController;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use DbSystel\DataObject\Server;

class ServerControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $realServiceLocator = $container->getServiceLocator();
        $serverService = $realServiceLocator->get('Order\Service\ServerService');

        $formElementManager = $realServiceLocator->get('FormElementManager');
        $serverForm = $formElementManager->get('MasterData\Form\ServerForm');

        $service = new ServerController(new Server(), $serverService);
        $service->setServerForm($serverForm);

        return $service;
    }

}