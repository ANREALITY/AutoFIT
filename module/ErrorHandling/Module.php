<?php
namespace ErrorHandling;

use Zend\Mvc\MvcEvent;

class Module
{

    public function onBootstrap(MvcEvent $event)
    {
        $this->setUpNativeErrorHandling($event);
        $this->initErrorHandler($event);
        $this->initExceptionHandler($event);
        $this->initWarningHandler($event);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                ]
            ]
        ];
    }

    public function setUpNativeErrorHandling(MvcEvent $event)
    {
        $config = $event->getApplication()->getServiceManager()->get('Config')['errors'];
        if (isset($config['error_reporting'])) {
            error_reporting($config['error_reporting']);
        }
        if (isset($config['display_errors'])) {
            ini_set('display_errors', $config['display_errors']);
        }
    }

    public function initErrorHandler(MvcEvent $event)
    {
        set_exception_handler(
            function (\Throwable $exception) use($event) {
                $handler = $event->getApplication()
                    ->getServiceManager()
                    ->get('ErrorHandling\Handler\ErrorHandler');
                $handler->handle($exception, $event);
            });
    }

    public function initExceptionHandler(MvcEvent $event)
    {
        $sharedManager = $event->getApplication()
            ->getEventManager()
            ->getSharedManager();
        $serviceManager = $event->getApplication()->getServiceManager();
        $sharedManager->attach('Zend\Mvc\Application',
            MvcEvent::EVENT_DISPATCH_ERROR,
            function ($event) use($serviceManager) {
                $handler = $event->getApplication()
                    ->getServiceManager()
                    ->get('ErrorHandling\Handler\ExceptionHandler');
                $handler->handle($event);
            });
        $sharedManager->attach('Zend\Mvc\Application',
            MvcEvent::EVENT_RENDER_ERROR,
            function ($event) use($serviceManager) {
                $handler = $event->getApplication()
                    ->getServiceManager()
                    ->get('ErrorHandling\Handler\ExceptionHandler');
                $handler->handle($event);
            });
    }

    public function initWarningHandler(MvcEvent $event)
    {
        set_error_handler(
            function (int $errno, string $errstr, string $errfile = null, int $errline = 0, array $errcontext = []) use($event) {
                $handler = $event->getApplication()
                    ->getServiceManager()
                    ->get('ErrorHandling\Handler\WarningHandler');
                return $handler->handle($errno, $errstr, $errfile, $errline, $errcontext, $event);
            });
    }

}
