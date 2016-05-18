<?php
namespace ErrorHandling;

use Zend\Mvc\MvcEvent;

class Module
{

    public function onBootstrap(MvcEvent $event)
    {
        $this->initErrorHandler($event);
        $this->initExceptionHandler($event);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    public function initErrorHandler(MvcEvent $event)
    {
        set_exception_handler(
            function (\Throwable $exception) use($event) {
                $handler = $event->getApplication()->getServiceManager()->get('ErrorHandling\Handler\ErrorHandler');
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
            [
                MvcEvent::EVENT_DISPATCH_ERROR,
                MvcEvent::EVENT_RENDER_ERROR
            ],
            function ($event) use($serviceManager) {
                $handler = $event->getApplication()->getServiceManager()->get('ErrorHandling\Handler\ExceptionHandler');
                $handler->handle($event);
            });
    }

}
