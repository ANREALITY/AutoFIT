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
            './module/Base/src/i18n-resources/languages/de/Validate.php');
        AbstractValidator::setDefaultTranslator($translator);

        $serviceManager = $e->getApplication()->getServiceManager();
        $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();

        $authenticationService = $serviceManager->get('AuthenticationService');
        $viewModel->authenticationService = $authenticationService;
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
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ]
            ]
        ];
    }

}
