<?php
namespace ErrorHandling\Handler\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ErrorHandling\Handler\WarningHandler;

class WarningHandlerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['errors'];
        $logger = $serviceLocator->get('Logging\Logger\ErrorLogger');
        $translator = $serviceLocator->get('translator');
        $service = new WarningHandler($config, $logger, $translator);
        return $service;
    }

}
