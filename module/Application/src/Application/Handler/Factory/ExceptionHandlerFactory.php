<?php
namespace Application\Handler\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Handler\ExceptionHandler;

class ExceptionHandlerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['errors'];
        $logger = $serviceLocator->get('Application\Logger\ErrorLogger');
        $service = new ExceptionHandler($config, $logger);
        return $service;
    }
}
