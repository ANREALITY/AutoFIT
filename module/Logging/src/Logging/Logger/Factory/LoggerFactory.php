<?php
namespace Logging\Logger\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

class LoggerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['errors'];
        $writer = new Stream($config['error_log_folder'] . '/' . $config['error_log_file']);
        $writer->setLogSeparator(str_repeat(PHP_EOL, 2) . str_repeat('=', 250) . str_repeat(PHP_EOL, 2));
        $service = new Logger();
        $service->addWriter($writer);
        return $service;
    }
}
