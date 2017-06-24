<?php
namespace ErrorHandling\Handler\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use ErrorHandling\Handler\WarningHandler;

class WarningHandlerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['errors'];
        $logger = $container->get('Logging\Logger\ErrorLogger');
        $translator = $container->get('translator');
        $service = new WarningHandler($config, $logger, $translator);
        return $service;
    }

}
