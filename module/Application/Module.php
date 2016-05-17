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
                'ErrorLogger' => function ($sm) {
                    $logger = new \Zend\Log\Logger();
                    $writer = new \Zend\Log\Writer\Stream('./data/logs/' . 'error-' . date('Y-m-d') . '.log');
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
                $translator = $event->getApplication()
                    ->getServiceManager()
                    ->get('translator');
                $randomChars = md5(uniqid('', true));
                $errorReference = substr($randomChars, strlen($randomChars) / 5, 7);
                // error log
                $event->setParam('exception', $exception);
                $serviceManager = $event->getApplication()->getServiceManager();
                $extra = [
                    'error-reference' => $errorReference
                ];
                $serviceManager->get('ErrorLogger')->crit($event->getParam('exception'), $extra);
                // error page
                // @todo Make it dynamic! Since not every user should be able to see the technical error message.
                $userIsAdmin = true;
                $message = null;
                if ($userIsAdmin) {
                    @trigger_error($exception);
                    $lastErrorData = error_get_last();
                    $message = <<<MESSAGE
TYPE: {$lastErrorData['type']}
MESSAGE: {$lastErrorData['message']}
FILE: {$lastErrorData['file']}
LINE: {$lastErrorData['line']}
MESSAGE;
                }
                ob_start();
                xdebug_var_dump(debug_backtrace());
                $debugBacktrace = ob_get_clean();
                $output = [
                    // header
                    $translator->translate('An error occured. Please try later again.'),
                    // error reference
                    sprintf($translator->translate('Error reference: %s.'), $errorReference),
                    // error info
                    $message,
                    // debug backtrace
                    $debugBacktrace
                ];
                $fatalTemplatePath = __DIR__ . '/view/error/fatal.html';
                $body = file_get_contents($fatalTemplatePath);
                $body = str_replace(
                    [
                        '%__HEADER__%',
                        '%__ERROR_REFERENCE__%',
                        '%__ERROR_INFO__%',
                        '%__DEBUG_BACKTRACE__%'
                    ], $output, $body);
                echo $body;
                return true;
            });
    }

    public function initExceptionHandler($event)
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
                $randomChars = md5(uniqid('', true));
                $errorReference = substr($randomChars, strlen($randomChars) / 5, 7);
                $extra = [
                    'error-reference' => $errorReference
                ];
                // error log
                if ($event->getParam('exception')) {
                    $serviceManager->get('ErrorLogger')
                        ->crit($event->getParam('exception'), $extra);
                }
                // @todo Make it dynamic! Since not every user should be able to see the technical error message.
                $userIsAdmin = true;
                // error page
                $event->getViewModel()
                    ->setVariables(
                    [
                        'userIsAdmin' => $userIsAdmin,
                        'errorReference' => $errorReference
                    ]);
            });
    }

}
