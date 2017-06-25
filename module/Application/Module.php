<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Router\Http\RouteMatch;
use Zend\Validator\AbstractValidator;

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
        $translator->addTranslationFile('phpArray',
            './vendor/db-systel/dbs-common-lib/src/i18n-resources/languages/de/Validate.php');
        AbstractValidator::setDefaultTranslator($translator);

        $serviceManager = $e->getApplication()->getServiceManager();
        $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();

        $authenticationService = $serviceManager->get('AuthenticationService');
        $viewModel->authenticationService = $authenticationService;

        // Get event manager.
        $eventManager = $e->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        // Register the event listener method.
        $sharedEventManager->attach(
            AbstractActionController::class,
            MvcEvent::EVENT_DISPATCH,
            [$this, 'onDispatch'],
            100
        );
    }

    public function onDispatch(MvcEvent $mvcEvent)
    {
        $viewModel = $mvcEvent->getApplication()->getMvcEvent()->getViewModel();
        $routeMatch = $mvcEvent->getRouteMatch();
        $viewModel->currentRoute = $routeMatch instanceof RouteMatch
            ? $routeMatch->getMatchedRouteName() : null
        ;
    }

    public function getServiceConfig()
    {
        return [];
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/../../vendor/composer' . '/' . 'autoload_classmap.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'DbSystel' => __DIR__ . '/../../vendor/db-systel/dbs-common-lib/src'
                ]
            ]
        ];
    }

}
