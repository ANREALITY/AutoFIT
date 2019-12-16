<?php
namespace Authentication;

use Authentication\Controller\AuthController;
use Authentication\Service\AuthManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Uri\Http as HttpUri;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $event)
    {
        $eventManager = $event->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        $sharedEventManager->attach(
            AbstractActionController::class,
            MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch'], 100
        );
    }

    public function onDispatch(MvcEvent $event)
    {
        $controller = $event->getTarget();
        $controllerName = $event->getRouteMatch()->getParam('controller', null);
        // $controllerName = get_class($controller);
        $actionName = $event->getRouteMatch()->getParam('action', null);

        $actionName = str_replace('-', '', lcfirst(ucwords($actionName, '-')));

        $authManager = $event->getApplication()->getServiceManager()->get(AuthManager::class);

        // Remembering the URL of the page the user tried to access.
        // The user will be redirected to that URL after successful login.
        if ($controllerName != AuthController::class && ! $authManager->filterAccess($controllerName, $actionName)) {
            /** @var HttpUri $uri */
            $uri = $event->getApplication()->getRequest()->getUri();
            // Making the URL relative (remove scheme, user info, host name and port)
            // to avoid redirecting to other domain by a malicious user.
            $uri->setScheme(null)
                ->setHost(null)
                ->setPort(null)
                ->setUserInfo(null);
            $redirectUrl = $uri->toString();
            return $controller->redirect()->toRoute('login', [], ['query'=>['redirectUrl'=>$redirectUrl]]);
        }
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

}
