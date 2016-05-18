<?php
namespace Application\Handler\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Handler\ErrorHandler;

class ErrorHandlerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['errors'];
        $logger = $serviceLocator->get('Application\Logger\ErrorLogger');
        $translator = $serviceLocator->get('translator');
        $service = new ErrorHandler($config, $logger, $translator);
        return $service;
    }
}
