<?php
namespace Logging\Logger\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

class LoggerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['errors'];
        $writer = new Stream(
            $config['error_log_folder'] . DIRECTORY_SEPARATOR . str_replace('{date}', date('Y-m-d'), $config['error_log_file']));
        $writer->setLogSeparator(str_repeat(PHP_EOL, 2) . str_repeat('=', 250) . str_repeat(PHP_EOL, 2));
        $service = new Logger();
        $service->addWriter($writer);
        return $service;
    }

}
