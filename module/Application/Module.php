<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;
use Zend\Log\Logger;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Application;
use Zend\Stdlib\ResponseInterface;
use Zend\Log\Writer\Stream;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $translator = $e->getApplication()
            ->getServiceManager()
            ->get('translator');
        $translator->addTranslationFile('phpArray',
            './vendor/zendframework/zend-i18n-resources/languages/de/Zend_Validate.php');
        AbstractValidator::setDefaultTranslator($translator);

        $this->initErrorHandler($e);
        $this->initExceptionHandler($e);
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'ErrorLogger' => function ($serviceManager) {
                    $logger = new Logger();
                    $writer = new Stream('./data/logs/' . 'error-' . date('Y-m-d') . '.log');
                    $writer->setLogSeparator(str_repeat(PHP_EOL, 2) . str_repeat('=', 250) . str_repeat(PHP_EOL, 2));
                    $logger->addWriter($writer);
                    return $logger;
                }
            ]
        ];
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
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'DbSystel' => __DIR__ . '/../../vendor/db-systel/dbs-common-lib/src'
                ]
            ]
        ];
    }

    public function initErrorHandler(MvcEvent $event)
    {
        set_exception_handler(
            function (\Throwable $exception) use($event) {
                $handler = $event->getApplication()->getServiceManager()->get('Application\Handler\ErrorHandler');
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
                $handler = $event->getApplication()->getServiceManager()->get('Application\Handler\ExceptionHandler');
                $handler->handle($event);
            });
    }

}
