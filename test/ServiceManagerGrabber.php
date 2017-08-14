<?php
namespace Test;

use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

/**
 * Class ServiceManagerGrabber
 *
 * @package Test
 */
class ServiceManagerGrabber
{
    protected static $serviceConfig = null;

    public function getServiceManager()
    {
        $serviceManagerConfig = isset($this->getServiceConfig()['service_manager'])
            ? $this->getServiceConfig()['service_manager'] : []
        ;
        $serviceManager = new ServiceManager($serviceManagerConfig);
        $serviceManager->setService('ApplicationConfig', new ServiceManagerConfig($serviceManagerConfig));

        $serviceManager->get('ModuleManager')->loadModules();

        return $serviceManager;
    }

    public static function setServiceConfig($config)
    {
        static::$serviceConfig = $config;
    }

    public static function getServiceConfig()
    {
        return static::$serviceConfig;
    }

}
